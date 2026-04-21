<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gear_id' => 'required|exists:gears,id',
            'gear_name' => 'required|string',
            'transaction_id' => 'required|exists:transactions,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);
        abort_if($transaction->user_id !== auth()->id(), 403);

        Review::create([
            'gear_id' => $request->gear_id,
            'gear_name' => $request->gear_name,
            'transaction_id' => $request->transaction_id,
            'user_id' => auth()->id(),
            'customer_name' => auth()->user()->name,
            'rating' => $request->rating,
            'comment' => $request->comment ?? '',
        ]);

        return back()->with('success', 'Review berhasil ditambahkan.');
    }
}
