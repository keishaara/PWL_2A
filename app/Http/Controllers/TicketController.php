<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Support\TicketQr;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = $this->ownedTickets()
            ->with(['registration.event.category', 'registration.event.organization'])
            ->latest()
            ->paginate(6);

        return view('mahasiswa.tickets.index', compact('tickets'));
    }

    public function download(string $ticketCode)
    {
        $ticket = $this->ownedTickets()
            ->with(['registration.event.category', 'registration.event.organization', 'registration.user'])
            ->where('ticket_code', $ticketCode)
            ->firstOrFail();

        $pdf = Pdf::loadView('mahasiswa.tickets.pdf', [
            'ticket' => $ticket,
            'event'  => $ticket->registration->event,
            'user'   => $ticket->registration->user,
            'qr'     => TicketQr::dataUri($ticket->ticket_code, 300),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('E-Tiket-' . $ticket->ticket_code . '.pdf');
    }

    // hanya tiket milik mahasiswa yang login, dari pendaftaran yang sudah confirmed
    private function ownedTickets()
    {
        return Ticket::whereHas('registration', function ($q) {
            $q->where('user_id', Auth::id())
              ->where('status', 'confirmed');
        });
    }
}