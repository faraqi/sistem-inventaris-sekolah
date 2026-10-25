<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Http\Requests\StoreLoanRequest;
use App\Models\Item;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Automatically update overdue loans
        Loan::where('status', 'dipinjam')
            ->where('due_date', '<', now()->startOfDay())
            ->update(['status' => 'terlambat']);

        $query = Loan::with(['user', 'item.category', 'returnLog']);

        // Non-admin can only see their own loans
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%");
                })->orWhereHas('item', function ($qi) use ($search) {
                    $qi->where('name', 'like', "%{$search}%")
                       ->orWhere('code', 'like', "%{$search}%");
                });
            });
        }

        $loans = $query->latest()->paginate(10)->withQueryString();

        return view('loans.index', compact('loans'));
    }

    public function create(Request $request)
    {
        $selectedItem = null;
        if ($request->filled('item_id')) {
            $selectedItem = Item::find($request->item_id);
        }

        $items = Item::where('stock', '>', 0)->get();
        $users = User::where('role', 'user')->get();

        return view('loans.create', compact('items', 'users', 'selectedItem'));
    }

    public function store(StoreLoanRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        $userId = $user->isAdmin() ? $validated['user_id'] : $user->id;
        $borrower = User::findOrFail($userId);
        $item = Item::findOrFail($validated['item_id']);

        DB::transaction(function () use ($validated, $userId, $item, $borrower) {
            // Create Loan Record
            $loan = Loan::create([
                'user_id' => $userId,
                'item_id' => $item->id,
                'quantity' => $validated['quantity'],
                'loan_date' => $validated['loan_date'],
                'due_date' => $validated['due_date'],
                'status' => 'dipinjam',
            ]);

            // Decrement Item Stock
            $item->decrement('stock', $validated['quantity']);

            // Activity Log
            ActivityLogger::log(
                'create_loan',
                "Peminjaman diajukan oleh {$borrower->name} untuk {$validated['quantity']} unit {$item->name} ({$item->code})"
            );
        });

        return redirect()->route('loans.index')
            ->with('success', 'Pengajuan peminjaman barang berhasil dibuat.');
    }

    public function show(Loan $loan)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && $loan->user_id !== $user->id) {
            abort(403, 'Anda tidak dapat melihat detail peminjaman ini.');
        }

        $loan->load(['user', 'item.category', 'returnLog']);
        return view('loans.show', compact('loan'));
    }

    public function destroy(Loan $loan)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $restoredStock = 0;

        DB::transaction(function () use ($loan, &$restoredStock) {
            // Peminjaman aktif yang dihapus: stok barang harus kembali, jika tidak stok hilang selamanya
            if (in_array($loan->status, ['dipinjam', 'terlambat'])) {
                Item::withTrashed()->whereKey($loan->item_id)->increment('stock', $loan->quantity);
                $restoredStock = $loan->quantity;
            }

            $loan->delete(); // Soft delete
        });

        ActivityLogger::log(
            'delete_loan',
            "Menghapus data peminjaman #" . $loan->id . ($restoredStock ? " (stok dikembalikan {$restoredStock} unit)" : '')
        );

        return redirect()->route('loans.index')
            ->with('success', 'Data peminjaman berhasil dihapus (Soft Delete)' . ($restoredStock ? " dan stok {$restoredStock} unit dikembalikan." : '.'));
    }

    public function report(Request $request)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $query = Loan::with(['user', 'item.category', 'returnLog']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('loan_date', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->latest()->get();

        return view('loans.report', compact('loans'));
    }
}
