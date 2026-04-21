@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
    <h1 class="font-display font-bold text-2xl dark:text-white mb-6">Checkout</h1>
    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <h3 class="font-semibold mb-3 dark:text-white">Item yang Disewa</h3>
            <div class="space-y-3">
                @foreach($items as $item)
                <div class="flex items-center justify-between text-sm">
                    <div>
                        <p class="font-medium dark:text-white">{{ $item['gear_name'] }}</p>
                        <p class="text-xs text-gray-500">{{ $item['category'] }} × {{ $item['quantity'] }}</p>
                    </div>
                    <p class="font-semibold">Rp {{ number_format($item['price_per_day'] * $item['quantity'],0,',','.') }}/hari</p>
                </div>
                @endforeach
            </div>
            <div class="border-t dark:border-gray-700 mt-4 pt-3 flex justify-between text-sm font-bold">
                <span>Subtotal / hari</span>
                <span class="text-emerald-600">Rp {{ number_format($subtotalPerDay,0,',','.') }}</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5 space-y-4">
            <h3 class="font-semibold dark:text-white">Tanggal Sewa</h3>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Mulai Sewa</label>
                    <input type="date" name="rental_start" required value="{{ old('rental_start', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                    @error('rental_start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Selesai Sewa</label>
                    <input type="date" name="rental_end" required value="{{ old('rental_end', now()->addDays(3)->format('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                    @error('rental_end') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <h3 class="font-semibold mb-3 dark:text-white">Leader / Pemandu (Opsional)</h3>
            <select name="leader_id" class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                <option value="">Tanpa Leader</option>
                @foreach($leaders as $leader)
                <option value="{{ $leader->id }}">{{ $leader->name }} — Rp {{ number_format($leader->fee_per_day,0,',','.') }}/hari</option>
                @endforeach
            </select>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <h3 class="font-semibold mb-3 dark:text-white">Metode Pembayaran</h3>
            <div class="space-y-3">
                <label class="flex items-center p-3.5 border dark:border-gray-700 rounded-xl cursor-pointer hover:bg-emerald-50/50 dark:hover:bg-gray-700/80 hover:border-emerald-300 dark:hover:border-emerald-600 transition-all duration-200 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-900/20">
                    <input type="radio" name="payment_method" value="GoPay" required class="text-emerald-600 focus:ring-emerald-500 w-4 h-4 flex-shrink-0">
                    <div class="ml-3 flex-shrink-0 w-14 h-9 flex items-center justify-center rounded-lg p-1 overflow-hidden">
                        <img src="/images/payment/GoPay.svg" alt="Gopay" class="h-full w-auto object-contain">
                    </div>
                    <div class="ml-3 min-w-0">
                        <span class="block text-sm font-semibold dark:text-white">GoPay</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">No: 0812-3456-7890 (a.n. Mangku Rinjani)</span>
                    </div>
                </label>

                <label class="flex items-center p-3.5 border dark:border-gray-700 rounded-xl cursor-pointer hover:bg-orange-50/50 dark:hover:bg-gray-700/80 hover:border-orange-300 dark:hover:border-orange-600 transition-all duration-200 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-900/20">
                    <input type="radio" name="payment_method" value="ShopeePay" class="text-emerald-600 focus:ring-emerald-500 w-4 h-4 flex-shrink-0">
                    <div class="ml-3 flex-shrink-0 w-14 h-9 flex items-center justify-center rounded-lg p-1 overflow-hidden">
                        <img src="/images/payment/Spay.svg" alt="ShopeePay" class="h-full w-auto object-contain">
                    </div>
                    <div class="ml-3 min-w-0">
                        <span class="block text-sm font-semibold dark:text-white">ShopeePay</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">No: 0812-3456-7891 (a.n. Mangku Rinjani)</span>
                    </div>
                </label>

                <label class="flex items-center p-3.5 border dark:border-gray-700 rounded-xl cursor-pointer hover:bg-blue-50/50 dark:hover:bg-gray-700/80 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-200 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-900/20">
                    <input type="radio" name="payment_method" value="Bank BRI" class="text-emerald-600 focus:ring-emerald-500 w-4 h-4 flex-shrink-0">
                    <div class="ml-3 flex-shrink-0 w-14 h-9 flex items-center justify-center rounded-lg p-1 overflow-hidden">
                        <img src="/images/payment/bri.svg" alt="Bank BRI" class="h-full w-auto object-contain">
                    </div>
                    <div class="ml-3 min-w-0">
                        <span class="block text-sm font-semibold dark:text-white">Bank BRI</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">No Rek: 1234-01-005678-50-9 (a.n. Mangku Rinjani)</span>
                    </div>
                </label>

                <label class="flex items-center p-3.5 border dark:border-gray-700 rounded-xl cursor-pointer hover:bg-orange-50/50 dark:hover:bg-gray-700/80 hover:border-orange-300 dark:hover:border-orange-600 transition-all duration-200 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-900/20">
                    <input type="radio" name="payment_method" value="Bank BNI" class="text-emerald-600 focus:ring-emerald-500 w-4 h-4 flex-shrink-0">
                    <div class="ml-3 flex-shrink-0 w-14 h-9 flex items-center justify-center rounded-lg p-1 overflow-hidden">
                        <img src="/images/payment/bni.svg" alt="Bank BNI" class="h-full w-auto object-contain">
                    </div>
                    <div class="ml-3 min-w-0">
                        <span class="block text-sm font-semibold dark:text-white">Bank BNI</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">No Rek: 0987654321 (a.n. Mangku Rinjani)</span>
                    </div>
                </label>
            </div>
            @error('payment_method') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl font-semibold transition shadow-sm text-sm">
            Buat Pesanan
        </button>
    </form>
</div>
@endsection
