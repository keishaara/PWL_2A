<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Organization;
use App\Models\Registration;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AttendanceAndReviewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.key' => str_repeat('a', 32)]);
    }

    public function test_organizer_can_check_in_a_confirmed_ticket_once(): void
    {
        [$organizer, $event, $ticket, $student] = $this->eventWithTicket();

        $this->actingAs($organizer)
            ->post(route('organisasi.attendance.check-in', $event), ['ticket_code' => $ticket->ticket_code])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => 'used',
        ]);
        $this->assertNotNull($ticket->fresh()->checked_in_at);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $student->id,
            'title' => 'Presensi Berhasil',
        ]);

        $this->post(route('organisasi.attendance.check-in', $event), ['ticket_code' => $ticket->ticket_code])
            ->assertSessionHasErrors('ticket_code');
        $this->assertDatabaseCount('notifications', 1);
    }

    public function test_certificate_is_not_available_before_check_in(): void
    {
        [$organizer, $event, $ticket, $student] = $this->eventWithTicket();
        Storage::fake('local');

        $this->actingAs($student)
            ->get(route('certificates.download', $ticket->ticket_code))
            ->assertNotFound();

        $this->actingAs($organizer)
            ->post(route('organisasi.attendance.check-in', $event), ['ticket_code' => $ticket->ticket_code])
            ->assertSessionHas('success');

        $this->actingAs($student)
            ->get(route('certificates.download', $ticket->ticket_code))
            ->assertDownload('Sertifikat-seminar-kampus-mahasiswa.pdf');

        $this->assertDatabaseCount('certificates', 1);
        $this->assertCount(1, Storage::disk('local')->allFiles('certificates'));
    }

    public function test_attendance_review_and_student_ticket_pages_render(): void
    {
        [$organizer, $event, , $student] = $this->eventWithTicket();

        $this->actingAs($organizer)
            ->get(route('organisasi.attendance.index'))
            ->assertOk()
            ->assertSee($event->title);
        $this->get(route('organisasi.attendance.show', $event))
            ->assertOk()
            ->assertSee('Tandai Hadir');
        $this->get(route('organisasi.reviews.index'))->assertOk();

        $this->actingAs($student)
            ->get(route('tickets.index'))
            ->assertOk()
            ->assertSee('E-Tiket Saya');
    }

    public function test_only_attendees_can_review_completed_events(): void
    {
        [, $event, $ticket, $student] = $this->eventWithTicket();
        $event->update(['end_date' => now()->subHour()]);

        $this->actingAs($student)
            ->post(route('reviews.store', $ticket->ticket_code), [
                'rating' => 5,
                'comment' => 'Acara sangat bermanfaat.',
            ])
            ->assertSessionHasErrors('review');
        $this->assertDatabaseCount('event_reviews', 0);

        $ticket->update(['status' => 'used', 'checked_in_at' => now()]);
        $this->post(route('reviews.store', $ticket->ticket_code), [
            'rating' => 5,
            'comment' => 'Acara sangat bermanfaat.',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('event_reviews', [
            'ticket_id' => $ticket->id,
            'event_id' => $event->id,
            'user_id' => $student->id,
            'rating' => 5,
        ]);
    }

    public function test_organizer_cannot_check_in_ticket_for_another_organizations_event(): void
    {
        [$organizer, $event, $ticket] = $this->eventWithTicket();
        $otherOrganizer = User::create([
            'name' => 'Organizer Lain',
            'email' => 'other@example.test',
            'password' => 'password',
            'role' => 'organizer',
        ]);

        $this->actingAs($otherOrganizer)
            ->post(route('organisasi.attendance.check-in', $event), ['ticket_code' => $ticket->ticket_code])
            ->assertNotFound();

        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'status' => 'unused']);
    }

    public function test_organizer_can_only_check_in_during_the_event_dates(): void
    {
        [$organizer, $event, $ticket] = $this->eventWithTicket();
        $event->update([
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
        ]);

        $this->actingAs($organizer)
            ->post(route('organisasi.attendance.check-in', $event), ['ticket_code' => $ticket->ticket_code])
            ->assertSessionHasErrors('ticket_code');

        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'status' => 'unused']);
    }

    public function test_admin_approval_notifies_the_organizer_once(): void
    {
        [$organizer, $event] = $this->eventWithTicket();
        $event->update(['status' => 'pending']);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.events.approve', $event))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('notifications', [
            'user_id' => $organizer->id,
            'title' => 'Acara Disetujui',
        ]);

        $this->post(route('admin.events.approve', $event));
        $this->assertDatabaseCount('notifications', 1);

        Notification::create([
            'user_id' => $admin->id,
            'title' => 'Notifikasi Admin',
            'message' => 'Pesan khusus admin.',
        ]);
        $this->get(route('admin.dashboard'))->assertOk()->assertSee('Notifikasi Admin');
    }

    public function test_admin_rejection_notifies_the_organizer_with_the_reason(): void
    {
        [$organizer, $event] = $this->eventWithTicket();
        $event->update(['status' => 'pending']);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.events.reject', $event), ['rejection_reason' => 'Informasi belum lengkap.'])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('notifications', [
            'user_id' => $organizer->id,
            'title' => 'Acara Ditolak',
            'message' => "Acara '{$event->title}' ditolak. Alasan: Informasi belum lengkap.",
        ]);
    }

    private function eventWithTicket(): array
    {
        $organizer = User::create([
            'name' => 'Organizer',
            'email' => 'organizer@example.test',
            'password' => 'password',
            'role' => 'organizer',
        ]);
        $organization = Organization::create([
            'user_id' => $organizer->id,
            'name' => 'Organisasi Kampus',
        ]);
        $category = Category::create(['name' => 'Seminar', 'slug' => 'seminar']);
        $event = Event::create([
            'organization_id' => $organization->id,
            'category_id' => $category->id,
            'title' => 'Seminar Kampus',
            'slug' => 'seminar-kampus',
            'description' => 'Acara seminar kampus.',
            'location' => 'Aula',
            'start_date' => now()->subDay(),
            'end_date' => now()->addDay(),
            'quota' => 30,
            'status' => 'approved',
        ]);
        $student = User::create([
            'name' => 'Mahasiswa',
            'email' => 'student@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $registration = Registration::create([
            'event_id' => $event->id,
            'user_id' => $student->id,
            'status' => 'confirmed',
        ]);
        $ticket = Ticket::create([
            'registration_id' => $registration->id,
            'ticket_code' => 'TIX-TEST123',
            'status' => 'unused',
        ]);

        return [$organizer, $event, $ticket, $student];
    }
}
