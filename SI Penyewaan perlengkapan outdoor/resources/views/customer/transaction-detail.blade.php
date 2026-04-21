@extends('layouts.customer')
@section('customer-content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('customer.transactions') }}" class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <h2 class="font-display font-bold text-2xl dark:text-white">Detail Transaksi</h2>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-6 space-y-5">
        <div class="flex flex-wrap justify-between gap-3">
            <div><p class="font-mono text-lg font-bold dark:text-white">{{ $transaction->code }}</p><p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p></div>
            @php $sc = ['Menunggu Konfirmasi'=>'bg-yellow-100 text-yellow-700','Dikonfirmasi'=>'bg-blue-100 text-blue-700','Dipinjam'=>'bg-purple-100 text-purple-700','Selesai'=>'bg-emerald-100 text-emerald-700','Ditolak'=>'bg-red-100 text-red-700','Terlambat'=>'bg-orange-100 text-orange-700','Dikembalikan'=>'bg-teal-100 text-teal-700']; @endphp
            <span class="text-sm px-3 py-1 rounded-full font-medium self-start {{ $sc[$transaction->status] ?? 'bg-gray-100' }}">{{ $transaction->status }}</span>
        </div>
        <div class="grid sm:grid-cols-2 gap-4 text-sm">
            <div><span class="text-gray-500">Pelanggan:</span> {{ $transaction->customer_name }}</div>
            <div><span class="text-gray-500">Email:</span> {{ $transaction->customer_email }}</div>
            <div><span class="text-gray-500">Periode Sewa:</span> {{ $transaction->rental_start->format('d/m/Y') }} — {{ $transaction->rental_end->format('d/m/Y') }}</div>
            <div><span class="text-gray-500">Durasi:</span> {{ $transaction->total_days }} hari</div>
            @if($transaction->leader_name)<div><span class="text-gray-500">Leader:</span> {{ $transaction->leader_name }} (Rp {{ number_format($transaction->leader_fee,0,',','.') }}/hari)</div>@endif
            @if($transaction->payment_method)<div><span class="text-gray-500">Metode Pembayaran:</span> {{ $transaction->payment_method }}</div>@endif
        </div>
        <div>
            <h4 class="font-semibold text-sm mb-2 dark:text-white">Item yang Disewa</h4>
            <div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="text-left text-xs text-gray-500 border-b dark:border-gray-700"><th class="pb-2">Nama</th><th class="pb-2 text-center">Qty</th><th class="pb-2 text-right">Harga/hari</th><th class="pb-2 text-right">Subtotal</th></tr></thead><tbody>
            @foreach($transaction->items as $item)
            <tr class="border-b dark:border-gray-700/50"><td class="py-2">{{ $item->gear_name }}</td><td class="py-2 text-center">{{ $item->quantity }}</td><td class="py-2 text-right">Rp {{ number_format($item->price_per_day,0,',','.') }}</td><td class="py-2 text-right font-semibold">Rp {{ number_format($item->subtotal,0,',','.') }}</td></tr>
            @endforeach
            </tbody></table></div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 space-y-1 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Biaya Gear</span><span>Rp {{ number_format($transaction->gear_cost,0,',','.') }}</span></div>
            @if($transaction->leader_cost)<div class="flex justify-between"><span class="text-gray-500">Biaya Leader</span><span>Rp {{ number_format($transaction->leader_cost,0,',','.') }}</span></div>@endif
            @if($transaction->late_fee)<div class="flex justify-between text-red-600"><span>Denda Keterlambatan</span><span>Rp {{ number_format($transaction->late_fee,0,',','.') }}</span></div>@endif
            <div class="flex justify-between font-bold text-base border-t dark:border-gray-700 pt-2 mt-2"><span>Total</span><span class="text-emerald-600">Rp {{ number_format($transaction->total_cost,0,',','.') }}</span></div>
        </div>
        @if($transaction->payment_proof_url)
        <div><h4 class="font-semibold text-sm mb-2 dark:text-white">Bukti Pembayaran</h4><img src="{{ $transaction->payment_proof_url }}" alt="Bukti" class="rounded-lg max-w-sm border"></div>
        @endif
        @if($transaction->rejection_reason)
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4"><p class="text-red-700 dark:text-red-300 text-sm"><strong>Alasan Penolakan:</strong> {{ $transaction->rejection_reason }}</p></div>
        @endif
        <div class="flex gap-2">
            @if(in_array($transaction->status, ['Menunggu Konfirmasi','Ditolak']))
            <a href="{{ route('customer.payment', $transaction) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Upload Bukti Pembayaran</a>
            @endif
        </div>
    </div>
</div>
@endsection
