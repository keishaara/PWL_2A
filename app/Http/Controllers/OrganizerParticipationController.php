<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventReview;
use App\Models\Notification;
use App\Models\Organization;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizerParticipationController extends Controller
{
    public function attendanceIndex()
    {
        $organization = $this->organization();
        $events = Event::where('organization_id', $organization->id)
            ->withCount([
                'registrations as confirmed_registrations_count' => fn ($query) => $query->where('status', 'confirmed'),
                'registrations as checked_in_count' => fn ($query) => $query
                    ->where('status', 'confirmed')
                    ->whereHas('ticket', fn ($ticket) => $ticket->where('status', 'used')),
            ])
            ->latest()
            ->paginate(8);

        return view('organisasi.attendance.index', compact('events'));
    }

    public function attendance(Event $event)
    {
        $event = $this->ownedEvent($event);
        $registrations = $event->registrations()
            ->with(['user', 'ticket'])
            ->where('status', 'confirmed')
            ->latest()
            ->paginate(15);

        return view('organisasi.attendance.show', compact('event', 'registrations'));
    }

    public function checkIn(Request $request, Event $event)
    {
        $event = $this->ownedEvent($event);
        $validated = $request->validate([
            'ticket_code' => ['required', 'string', 'max:255'],
        ]);

        $result = DB::transaction(function () use ($event, $validated) {
            $ticket = Ticket::where('ticket_code', $validated['ticket_code'])
                ->whereHas('registration', fn ($query) => $query
                    ->where('event_id', $event->id)
                    ->where('status', 'confirmed'))
                ->lockForUpdate()
                ->first();

            if (! $ticket) {
                return 'invalid';
            }

            if ($ticket->status === 'used') {
                return 'used';
            }

            $ticket->update([
                'status' => 'used',
                'checked_in_at' => now(),
            ]);

            $ticket->load('registration');
            Notification::create([
                'user_id' => $ticket->registration->user_id,
                'title' => 'Presensi Berhasil',
                'message' => "Presensi kamu untuk acara '{$event->title}' telah dicatat.",
            ]);

            return 'checked_in';
        });

        if ($result === 'invalid') {
            return back()->withErrors(['ticket_code' => 'Kode tiket tidak valid untuk acara ini atau pendaftarannya belum dikonfirmasi.']);
        }

        if ($result === 'used') {
            return back()->withErrors(['ticket_code' => 'Tiket ini sudah digunakan untuk check-in.']);
        }

        return back()->with('success', 'Presensi peserta berhasil dicatat.');
    }

    public function reviews()
    {
        $organization = $this->organization();
        $reviews = EventReview::with(['event', 'user'])
            ->whereHas('event', fn ($query) => $query->where('organization_id', $organization->id))
            ->latest()
            ->paginate(12);

        return view('organisasi.reviews.index', compact('reviews'));
    }

    private function organization(): Organization
    {
        $user = Auth::user();

        return $user->organization ?? Organization::firstOrCreate(
            ['user_id' => $user->id],
            ['name' => $user->name, 'description' => 'Organisasi Mahasiswa']
        );
    }

    private function ownedEvent(Event $event): Event
    {
        return Event::where('organization_id', $this->organization()->id)
            ->findOrFail($event->id);
    }
}
