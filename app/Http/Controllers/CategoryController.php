<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('items');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->input('filter') === 'with_items') {
            $query->has('items');
        } elseif ($request->input('filter') === 'empty') {
            $query->doesntHave('items');
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        ActivityLogger::log(
            'create_category',
            'Menambahkan kategori baru: "' . $category->name . '"'
        );

        return redirect()->route('categories.index')
            ->with('success', 'Kategori "' . $category->name . '" berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $oldName = $category->name;
        $category->update($request->validated());

        ActivityLogger::log(
            'update_category',
            'Mengubah nama kategori dari "' . $oldName . '" menjadi "' . $category->name . '"'
        );

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->items()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Kategori "' . $category->name . '" tidak dapat dihapus karena masih memiliki barang terhubung.');
        }

        $name = $category->name;
        $category->delete();

        ActivityLogger::log(
            'delete_category',
            'Menghapus kategori: "' . $name . '"'
        );

        return redirect()->route('categories.index')
            ->with('success', 'Kategori "' . $name . '" berhasil dihapus.');
    }
}
