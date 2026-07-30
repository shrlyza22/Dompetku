<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Tampilkan daftar kategori
    public function index()
    {
        $categories = auth()->user()->categories()
            ->withCount('transactions')
            ->get();
        return view('categories.index', compact('categories'));
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'type'  => 'required|in:income,expense',
            'color' => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        $category = auth()->user()->categories()->create($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Kategori baru berhasil dibuat!',
                'category' => $category
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dibuat!');
    }

    // Perbarui kategori
    public function update(Request $request, Category $category)
    {
        $category = auth()->user()->categories()->findOrFail($category->id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'type'  => 'required|in:income,expense',
            'color' => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        $category = auth()->user()->categories()->findOrFail($category->id);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
