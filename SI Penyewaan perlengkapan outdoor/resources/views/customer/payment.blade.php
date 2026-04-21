@extends('layouts.customer')
@section('customer-content')
<div class="space-y-6">
    <h2 class="font-display font-bold text-2xl dark:text-white">Upload Bukti Pembayaran</h2>
    <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-6">
        <p class="text-sm text-gray-500 mb-4">Transaksi: <span class="font-mono font-semibold dark:text-white">{{ $transaction->code }}</span></p>
        <p class="text-sm mb-6">Total: <span class="font-bold text-emerald-600 text-lg">Rp {{ number_format($transaction->total_cost,0,',','.') }}</span></p>
        <form action="{{ route('customer.payment.upload', $transaction) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1 dark:text-white">Foto Bukti Pembayaran</label>
                <input type="file" name="payment_proof" accept="image/*" required class="block w-full text-sm border dark:border-gray-700 rounded-lg p-2 bg-white dark:bg-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                @error('payment_proof') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">Upload Bukti</button>
        </form>
    </div>
</div>
@endsection
