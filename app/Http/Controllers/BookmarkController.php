<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $events = Event::with(['category', 'organization'])
            ->where('status', 'approved')
            ->whereIn('id', Auth::user()->bookmarkedEventIds())
            ->orderBy('start_date', 'asc')
            ->paginate(9);

        return view('mahasiswa.bookmarks.index', compact('events'));
    }

    public function toggle(Request $request, string $slug)
    {
        $event = Event::where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        $query = History::where('user_id', Auth::id())
            ->where('action', 'bookmark')
            ->where('description', (string) $event->id);

        if ($query->exists()) {
            $query->delete();
            return back()->with('bookmark', "'{$event->title}' dihapus dari daftar tersimpan.");
        }

        History::create([
            'user_id'     => Auth::id(),
            'action'      => 'bookmark',
            'description' => (string) $event->id,
        ]);

        return back()->with('bookmark', "'{$event->title}' disimpan. Cek di halaman Event Tersimpan.");
    }
}