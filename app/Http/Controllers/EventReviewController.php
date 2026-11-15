<?php

namespace App\Http\Controllers;

use App\Models\EventReview;
use App\Models\Notification;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventReviewController extends Controller
{
    public function store(Request $request, string $ticketCode)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $ticket = Ticket::with(['registration.event.organization'])
            ->where('ticket_code', $ticketCode)
            ->whereHas('registration', fn ($query) => $query
                ->where('user_id', Auth::id())
                ->where('status', 'confirmed'))
            ->firstOrFail();

        if ($ticket->status !== 'used' || $ticket->registration->event->end_date->isFuture()) {
            return back()->withErrors(['review' => 'Ulasan hanya dapat diberikan setelah kamu hadir di acara yang telah selesai.']);
        }

        $review = EventReview::updateOrCreate(
            ['ticket_id' => $ticket->id],
            [
                'event_id' => $ticket->registration->event_id,
                'user_id' => Auth::id(),
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]
        );

        if ($review->wasRecentlyCreated && $ticket->registration->event->organization) {
            Notification::create([
                'user_id' => $ticket->registration->event->organization->user_id,
                'title' => 'Ulasan Acara Baru',
                'message' => Auth::user()->name . " memberi rating {$review->rating}/5 untuk acara '{$ticket->registration->event->title}'.",
            ]);
        }

        return redirect()->route('tickets.index')->with('success', 'Terima kasih, ulasan acara berhasil disimpan.');
    }
}
