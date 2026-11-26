<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function download(string $ticketCode)
    {
        $ticket = Ticket::with(['registration.event', 'registration.user'])
            ->where('ticket_code', $ticketCode)
            ->where('status', 'used')
            ->whereHas('registration', fn($query) => $query
                ->where('user_id', Auth::id())
                ->where('status', 'confirmed'))
            ->firstOrFail();

        $event = $ticket->registration->event;
        $user = $ticket->registration->user;
        $certificate = Certificate::firstOrCreate(
            ['ticket_id' => $ticket->id],
            [
                'user_id' => $user->id,
                'event_id' => $event->id,
                'certificate_number' => 'CERT-' . strtoupper(Str::random(12)),
            ]
        );

        $filePath = 'certificates/' . $certificate->certificate_number . '.pdf';
        if (! Storage::disk('local')->exists($filePath)) {
            $pdf = Pdf::loadView('mahasiswa.certificates.pdf', compact('certificate', 'event', 'user'))
                ->setPaper('a4', 'landscape');
            Storage::disk('local')->put($filePath, $pdf->output());
            $certificate->update(['file_path' => $filePath]);
        }

        $fileName = 'Sertifikat-' . Str::slug($event->title) . '-' . Str::slug($user->name) . '.pdf';

        return Storage::download($filePath, $fileName);
    }
}
