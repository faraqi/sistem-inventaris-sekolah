<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Item;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Check and update overdue loans automatically
        Loan::where('status', 'dipinjam')
            ->where('due_date', '<', now()->startOfDay())
            ->update(['status' => 'terlambat']);

        if ($user->isAdmin()) {
            $totalItems = Item::count();
            $totalStock = Item::sum('stock');
            $activeLoansCount = Loan::where('status', 'dipinjam')->sum('quantity');
            $activeLoansTxCount = Loan::where('status', 'dipinjam')->count();
            $overdueLoansCount = Loan::where('status', 'terlambat')->sum('quantity');
            $overdueLoansTxCount = Loan::where('status', 'terlambat')->count();

            // Barang Paling Sering Dipinjam
            $popularItems = Item::withCount('loans')
                ->orderByDesc('loans_count')
                ->take(5)
                ->get();

            // User Paling Aktif Meminjam
            $activeUsers = User::where('role', 'user')
                ->withCount('loans')
                ->orderByDesc('loans_count')
                ->take(5)
                ->get();

            // Recent Activity Logs
            $recentActivities = ActivityLog::with('user')
                ->latest()
                ->take(5)
                ->get();

            // Monthly Loans Trend Data
            $driver = DB::connection()->getDriverName();
            $dateFormat = $driver === 'sqlite'
                ? "strftime('%Y-%m', loan_date)"
                : "DATE_FORMAT(loan_date, '%Y-%m')";

            $monthlyLoans = Loan::select(
                DB::raw("{$dateFormat} as month"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get()
            ->reverse();

            return view('dashboard.admin', compact(
                'totalItems',
                'totalStock',
                'activeLoansCount',
                'activeLoansTxCount',
                'overdueLoansCount',
                'overdueLoansTxCount',
                'popularItems',
                'activeUsers',
                'recentActivities',
                'monthlyLoans'
            ));
        } else {
            // User Dashboard
            $myTotalLoans = Loan::where('user_id', $user->id)->count();
            $myActiveLoans = Loan::with(['item.category', 'returnLog'])
                ->where('user_id', $user->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->latest()
                ->get();

            $myReturnedLoans = Loan::where('user_id', $user->id)->where('status', 'dikembalikan')->count();
            $myOverdueCount = Loan::where('user_id', $user->id)->where('status', 'terlambat')->count();

            // Count past returned loans that were returned late (after due_date)
            $lateReturnsCount = Loan::where('user_id', $user->id)
                ->where('status', 'dikembalikan')
                ->whereHas('returnLog', function ($q) {
                    $q->whereColumn('return_logs.returned_at', '>', 'loans.due_date');
                })
                ->count();

            $totalLateTransactions = $myOverdueCount + $lateReturnsCount;

            // Calculate Compliance Score (%)
            if ($myTotalLoans > 0) {
                $complianceScore = max(0, min(100, round((($myTotalLoans - $totalLateTransactions) / $myTotalLoans) * 100)));
            } else {
                $complianceScore = 100;
            }

            // Categories for filter
            $categories = Category::all();

            // Available Items Catalog
            $itemQuery = Item::with('category')->where('stock', '>', 0);

            if ($request->filled('search')) {
                $search = $request->search;
                $itemQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
                });
            }

            $availableItems = $itemQuery->latest()->get();

            return view('dashboard.user', compact(
                'myTotalLoans',
                'myActiveLoans',
                'myReturnedLoans',
                'myOverdueCount',
                'complianceScore',
                'categories',
                'availableItems'
            ));
        }
    }
}
