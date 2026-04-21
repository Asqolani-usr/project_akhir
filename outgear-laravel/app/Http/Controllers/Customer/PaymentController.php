<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show(Transaction $transaction)
    {
        abort_if($transaction->user_id !== auth()->id(), 403);
        return view('customer.payment', compact('transaction'));
    }

    public function upload(Request $request, Transaction $transaction)
    {
        abort_if($transaction->user_id !== auth()->id(), 403);

        $request->validate([
            'payment_proof' => 'required|image|max:5120',
        ]);

        if ($transaction->payment_proof && Storage::disk('public')->exists($transaction->payment_proof)) {
            Storage::disk('public')->delete($transaction->payment_proof);
        }

        $path = $request->file('payment_proof')->store('payments', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'payment_confirmed' => false,
            'status' => 'Menunggu Konfirmasi',
            'rejection_reason' => null,
        ]);

        return redirect()->route('customer.transactions')
            ->with('success', 'Bukti pembayaran berhasil diupload.');
    }
}
