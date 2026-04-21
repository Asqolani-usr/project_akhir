<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id())->with('items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->get();

        return view('customer.transactions', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        abort_if($transaction->user_id !== auth()->id(), 403);
        $transaction->load('items', 'reviews');

        return view('customer.transaction-detail', compact('transaction'));
    }
}
