<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Http\Requests\StoreReturnLogRequest;
use App\Models\Loan;
use App\Models\ReturnLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnLog::with(['loan.user', 'loan.item']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('loan', function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%");
                })->orWhereHas('item', function ($qi) use ($search) {
                    $qi->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('condition')) {
            $query->where('condition_on_return', $request->condition);
        }

        $returnLogs = $query->latest()->paginate(10)->withQueryString();

        return view('returns.index', compact('returnLogs'));
    }

    public function create(Request $request)
    {
        $selectedLoan = null;
        if ($request->filled('loan_id')) {
            $selectedLoan = Loan::with(['user', 'item'])->find($request->loan_id);
        }

        $activeLoans = Loan::with(['user', 'item'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->get();

        return view('returns.create', compact('activeLoans', 'selectedLoan'));
    }

    public function store(StoreReturnLogRequest $request)
    {
        $validated = $request->validated();
        $loan = Loan::with(['item', 'user'])->findOrFail($validated['loan_id']);

        DB::transaction(function () use ($validated, $loan) {
            // 1. Create Return Log
            $returnLog = ReturnLog::create([
                'loan_id' => $loan->id,
                'returned_at' => $validated['returned_at'],
                'condition_on_return' => $validated['condition_on_return'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // 2. Update Loan Status
            $loan->update(['status' => 'dikembalikan']);

            // 3. Restore Item Stock
            $loan->item->increment('stock', $loan->quantity);

            // 4. Update Item Condition if changed
            if ($validated['condition_on_return'] !== $loan->item->condition) {
                $loan->item->update(['condition' => $validated['condition_on_return']]);
            }

            // 5. Activity Log
            ActivityLogger::log(
                'verify_return',
                "Pengembalian diproses: {$loan->quantity} unit {$loan->item->name} oleh {$loan->user->name} dengan kondisi {$validated['condition_on_return']}"
            );
        });

        return redirect()->route('returns.index')
            ->with('success', 'Pengembalian barang berhasil dicatat dan stok telah diperbarui.');
    }

    public function show(ReturnLog $returnLog)
    {
        $returnLog->load(['loan.user', 'loan.item.category']);
        return view('returns.show', compact('returnLog'));
    }
}
