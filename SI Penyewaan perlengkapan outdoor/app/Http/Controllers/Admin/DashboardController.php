<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Gear;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_gear' => Gear::count(),
            'total_customers' => Customer::count(),
            'active_transactions' => Transaction::whereIn('status', Transaction::ACTIVE_STATUSES)->count(),
            'total_revenue' => Transaction::where('status', 'Selesai')->sum('total_cost'),
        ];

        $recentTransactions = Transaction::with('items')->latest()->take(5)->get();
        $lowStockGear = Gear::where('stock', '<=', 2)->where('is_available', true)->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions', 'lowStockGear'));
    }
}
