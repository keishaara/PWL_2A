<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['organization', 'category'])->latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $events = $query->paginate(10);

        $stats = [
            'all'      => Event::count(),
            'pending'  => Event::where('status', 'pending')->count(),
            'approved' => Event::where('status', 'approved')->count(),
            'rejected' => Event::where('status', 'rejected')->count(),
        ];

        return view('admin.events.index', compact('events', 'stats'));
    }

    public function show($id)
    {
        $event = Event::with(['organization', 'category'])
            ->findOrFail($id);

        return view('admin.events.show', compact('event'));
    }

    public function approve($id)
    {
        $event = Event::findOrFail($id);
        $event->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        return back()->with('success', "Acara '{$event->title}' berhasil disetujui dan kini tayang di katalog!");
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:5|max:500',
        ], [
            'rejection_reason.required' => 'Wajib menyertakan alasan penolakan acara.',
            'rejection_reason.min'      => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $event = Event::findOrFail($id);
        $event->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', "Acara '{$event->title}' telah ditolak beserta alasan penolakannya.");
    }
}