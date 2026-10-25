<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Item::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->boolean('trashed') && $user->isAdmin()) {
            $query->onlyTrashed();
        }

        $items = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(StoreItemRequest $request)
    {
        $item = Item::create($request->validated());

        ActivityLogger::log(
            'create_item',
            'Menambahkan barang baru: "' . $item->name . '" (' . $item->code . ') stok ' . $item->stock
        );

        return redirect()->route('items.index')
            ->with('success', 'Barang "' . $item->name . '" berhasil ditambahkan.');
    }

    public function show(Item $item)
    {
        $item->load(['category', 'loans.user', 'loans.returnLog']);
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->update($request->validated());

        ActivityLogger::log(
            'update_item',
            'Perbarui data barang: "' . $item->name . '" (' . $item->code . ')'
        );

        return redirect()->route('items.index')
            ->with('success', 'Barang "' . $item->name . '" berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $name = $item->name;
        $code = $item->code;
        $item->delete(); // Soft Delete

        ActivityLogger::log(
            'delete_item',
            'Menghapus barang (Soft Delete): "' . $name . '" (' . $code . ')'
        );

        return redirect()->route('items.index')
            ->with('success', 'Barang "' . $name . '" berhasil dihapus (Soft Delete).');
    }

    public function restore($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $item->restore();

        ActivityLogger::log(
            'restore_item',
            'Mengembalikan barang yang dihapus: "' . $item->name . '" (' . $item->code . ')'
        );

        return redirect()->route('items.index')
            ->with('success', 'Barang "' . $item->name . '" berhasil dikembalikan.');
    }
}
