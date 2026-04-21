<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $transactions = Transaction::where('user_id', $user->id)->latest()->get();

        $stats = [
            'total' => $transactions->count(),
            'active' => $transactions->whereIn('status', Transaction::ACTIVE_STATUSES)->count(),
            'completed' => $transactions->where('status', 'Selesai')->count(),
            'total_spent' => $transactions->sum('total_cost'),
        ];

        $recentTransactions = $transactions->take(5);

        return view('customer.dashboard', compact('stats', 'recentTransactions'));
    }
}
