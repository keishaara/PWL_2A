<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('events')->orderBy('name');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $categories = $query->paginate(10)->withQueryString();

        $stats = [
            'total'      => Category::count(),
            'with_event' => Category::has('events')->count(),
            'empty'      => Category::doesntHave('events')->count(),
        ];

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    // Halaman detail kategori
    public function show(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $eventsQuery = $category->events()
            ->with('organization')
            ->orderBy('start_date', 'desc');

        // Pencarian acara
        if ($request->filled('q')) {
            $eventsQuery->where(
                'title',
                'like',
                '%' . $request->q . '%'
            );
        }

        // Filter status acara
        if ($request->filled('status') &&
            in_array($request->status, ['pending', 'approved', 'rejected'], true)) {

            $eventsQuery->where('status', $request->status);
        }

        $events = $eventsQuery->paginate(10)->withQueryString();

        // Statistik acara berdasarkan kategori
        $stats = [
            'total'    => $category->events()->count(),
            'approved' => $category->events()->where('status', 'approved')->count(),
            'pending'  => $category->events()->where('status', 'pending')->count(),
            'rejected' => $category->events()->where('status', 'rejected')->count(),
        ];

        return view('admin.categories.show', compact(
            'category',
            'events',
            'stats'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            ['name' => 'required|string|min:3|max:100|unique:categories,name'],
            $this->messages()
        );

        $slug = Str::slug($data['name']);

        if (Category::where('slug', $slug)->exists()) {
            return back()->withInput()->withErrors([
                'name' => 'Nama ini menghasilkan slug yang sudah dipakai kategori lain. Gunakan nama yang berbeda.',
            ]);
        }

        Category::create([
            'name' => $data['name'],
            'slug' => $slug
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori '{$data['name']}' berhasil ditambahkan.");
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate(
            ['name' => 'required|string|min:3|max:100|unique:categories,name,' . $category->id],
            $this->messages()
        );

        $slug = Str::slug($data['name']);

        if (Category::where('slug', $slug)
            ->where('id', '!=', $category->id)
            ->exists()) {

            return back()->withInput()->withErrors([
                'name' => 'Nama ini menghasilkan slug yang sudah dipakai kategori lain. Gunakan nama yang berbeda.',
            ]);
        }

        $category->update([
            'name' => $data['name'],
            'slug' => $slug
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $category = Category::withCount('events')->findOrFail($id);

        if ($category->events_count > 0) {
            return back()->withErrors([
                'delete' => "Kategori '{$category->name}' tidak dapat dihapus karena masih dipakai {$category->events_count} acara. Pindahkan atau hapus acaranya terlebih dahulu.",
            ]);
        }

        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', "Kategori '{$name}' berhasil dihapus.");
    }

    private function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.min'      => 'Nama kategori minimal 3 karakter.',
            'name.max'      => 'Nama kategori maksimal 100 karakter.',
            'name.unique'   => 'Nama kategori sudah ada.',
        ];
    }
}
