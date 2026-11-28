<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrganizerEventController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $organization = $user->organization ?? Organization::firstOrCreate(
            ['user_id' => $user->id],
            ['name' => $user->name, 'description' => 'Organisasi Mahasiswa']
        );

        $query = Event::with('category')
            ->withCount(['registrations as participants_count' => fn ($q) => $q->where('status', 'confirmed')])
            ->where('organization_id', $organization->id)
            ->latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $events = $query->paginate(8);

        $stats = [
            'all'      => Event::where('organization_id', $organization->id)->count(),
            'pending'  => Event::where('organization_id', $organization->id)->where('status', 'pending')->count(),
            'approved' => Event::where('organization_id', $organization->id)->where('status', 'approved')->count(),
            'rejected' => Event::where('organization_id', $organization->id)->where('status', 'rejected')->count(),
        ];

        return view('organisasi.events.index', compact('events', 'stats', 'organization'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('organisasi.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $organization = $user->organization;

        $request->validate([
            'title'               => 'required|string|max:255',
            'category_id'         => 'required|exists:categories,id',
            'description'         => 'required|string',
            'location'            => 'required|string|max:255',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'quota'               => 'required|integer|min:1',
            'banner'              => 'required|image|mimes:jpeg,png,jpg|max:3072',
            'is_paid'             => 'required|in:0,1',
            'price'               => 'required_if:is_paid,1|nullable|numeric|min:0',
            'bank_name'           => 'required_if:is_paid,1|nullable|string|max:100',
            'bank_account_number' => 'required_if:is_paid,1|nullable|string|max:100',
            'bank_account_holder' => 'required_if:is_paid,1|nullable|string|max:100',
        ], [
            'title.required'          => 'Judul acara wajib diisi.',
            'category_id.required'    => 'Silakan pilih kategori acara.',
            'description.required'    => 'Deskripsi acara wajib diisi.',
            'location.required'       => 'Lokasi kegiatan wajib diisi.',
            'start_date.required'     => 'Tanggal mulai wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'quota.required'          => 'Kuota peserta wajib diisi.',
            'banner.required'         => 'Poster atau banner acara wajib diunggah.',
            'banner.image'            => 'Poster harus berupa file gambar (JPG, PNG).',
            'banner.max'              => 'Ukuran poster maksimal 3 MB.',
            'price.required_if'       => 'Harga tiket wajib diisi untuk event berbayar.',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        $slug = Str::slug($request->title) . '-' . Str::random(5);

        Event::create([
            'organization_id'     => $organization->id,
            'category_id'         => $request->category_id,
            'title'               => $request->title,
            'slug'                => $slug,
            'description'         => $request->description,
            'location'            => $request->location,
            'start_date'          => $request->start_date,
            'end_date'            => $request->end_date,
            'quota'               => $request->quota,
            'banner'              => $bannerPath,
            'price'               => $request->is_paid == '1' ? $request->price : 0,
            'bank_name'           => $request->is_paid == '1' ? $request->bank_name : null,
            'bank_account_number' => $request->is_paid == '1' ? $request->bank_account_number : null,
            'bank_account_holder' => $request->is_paid == '1' ? $request->bank_account_holder : null,
            'status'              => 'pending',
        ]);

        return redirect()->route('organisasi.dashboard')->with('success', 'Acara baru berhasil diajukan dan sedang menunggu verifikasi dari Admin!');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $event = Event::where('organization_id', $user->organization->id)->findOrFail($id);
        $categories = Category::all();
        if ($event->status === 'approved') {
            return redirect()->route('organisasi.dashboard')->with('error', 'Acara yang telah disetujui Admin tidak dapat diubah atau dihapus.');
        }
        return view('organisasi.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $event = Event::where('organization_id', $user->organization->id)->findOrFail($id);

        $request->validate([
            'title'               => 'required|string|max:255',
            'category_id'         => 'required|exists:categories,id',
            'description'         => 'required|string',
            'location'            => 'required|string|max:255',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'quota'               => 'required|integer|min:1',
            'banner'              => 'required|image|mimes:jpeg,png,jpg|max:3072',
            'is_paid'             => 'required|in:0,1',
            'price'               => 'required_if:is_paid,1|nullable|numeric|min:0',
            'bank_name'           => 'required_if:is_paid,1|nullable|string|max:100',
            'bank_account_number' => 'required_if:is_paid,1|nullable|string|max:100',
            'bank_account_holder' => 'required_if:is_paid,1|nullable|string|max:100',
        ]);

        $bannerPath = $event->banner;
        if ($request->hasFile('banner')) {
            if ($bannerPath && Storage::disk('public')->exists($bannerPath)) {
                Storage::disk('public')->delete($bannerPath);
            }
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        $event->update([
            'category_id'         => $request->category_id,
            'title'               => $request->title,
            'description'         => $request->description,
            'location'            => $request->location,
            'start_date'          => $request->start_date,
            'end_date'            => $request->end_date,
            'quota'               => $request->quota,
            'banner'              => $bannerPath,
            'price'               => $request->is_paid == '1' ? $request->price : 0,
            'bank_name'           => $request->is_paid == '1' ? $request->bank_name : null,
            'bank_account_number' => $request->is_paid == '1' ? $request->bank_account_number : null,
            'bank_account_holder' => $request->is_paid == '1' ? $request->bank_account_holder : null,
        ]);

        if ($event->status === 'approved') {
            return redirect()->route('organisasi.dashboard')->with('error', 'Acara yang telah disetujui Admin tidak dapat diubah atau dihapus.');
        }

        return redirect()->route('organisasi.dashboard')->with('success', 'Data acara berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $event = Event::where('organization_id', $user->organization->id)->findOrFail($id);

        if ($event->banner && Storage::disk('public')->exists($event->banner)) {
            Storage::disk('public')->delete($event->banner);
        }

        $event->delete();

        if ($event->status === 'approved') {
            return redirect()->route('organisasi.dashboard')->with('error', 'Acara yang telah disetujui Admin tidak dapat diubah atau dihapus.');
        }

        return redirect()->route('organisasi.dashboard')->with('success', 'Acara berhasil dihapus.');
    }
}