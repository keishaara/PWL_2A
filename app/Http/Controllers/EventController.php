<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Event::with(['category', 'organization'])
            ->where('status', 'approved');

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('location', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->orderBy('start_date', 'asc')->paginate(9);

        return view('events.eventcategory', compact('events', 'categories'));
    }

    public function show($slug)
    {
        $event = Event::with(['category', 'organization.user', 'registrations'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        $totalRegistered = $event->registrations()->where('status', '!=', 'cancelled')->count();
        $remainingQuota = max(0, $event->quota - $totalRegistered);

        return view('events.eventdetail', compact('event', 'remainingQuota'));
    }
}