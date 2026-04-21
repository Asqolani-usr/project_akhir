@extends('layouts.customer')
@section('customer-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="font-display font-bold text-2xl dark:text-white">Transaksi Saya</h2>
    </div>

    {{-- Filter --}}
    <form method="GET" class="flex flex-wrap gap-2">
        <a href="{{ route('customer.transactions') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium border transition {{ !request('status') ? 'bg-emerald-600 text-white border-emerald-600' : 'dark:border-gray-700 hover:bg-gray-100' }}">Semua</a>
        @foreach(['Menunggu Konfirmasi','Dikonfirmasi','Dipinjam','Selesai','Ditolak'] as $s)
        <a href="{{ route('customer.transactions', ['status'=>$s]) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium border transition {{ request('status')===$s ? 'bg-emerald-600 text-white border-emerald-600' : 'dark:border-gray-700 hover:bg-gray-100' }}">{{ $s }}</a>
        @endforeach
    </form>

    @if($transactions->isEmpty())
    <div class="text-center py-12">
        <p class="text-gray-500">Belum ada transaksi.</p>
        <a href="{{ route('gear.index') }}" class="mt-3 inline-block text-sm text-emerald-600 hover:underline">Mulai mencari perlengkapan →</a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($transactions as $trx)
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-3">
                <div>
                    <p class="font-mono text-sm font-semibold dark:text-white">{{ $trx->code }}</p>
                    <p class="text-xs text-gray-500">{{ $trx->created_at->format('d M Y, H:i') }}</p>
                </div>
                @php $sc = ['Menunggu Konfirmasi'=>'bg-yellow-100 text-yellow-700','Dikonfirmasi'=>'bg-blue-100 text-blue-700','Dipinjam'=>'bg-purple-100 text-purple-700','Selesai'=>'bg-emerald-100 text-emerald-700','Ditolak'=>'bg-red-100 text-red-700','Terlambat'=>'bg-orange-100 text-orange-700','Dikembalikan'=>'bg-teal-100 text-teal-700']; @endphp
                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $sc[$trx->status] ?? 'bg-gray-100' }}">{{ $trx->status }}</span>
            </div>
            <div class="grid sm:grid-cols-3 gap-3 text-sm mb-3">
                <div><span class="text-gray-500">Sewa:</span> {{ $trx->rental_start->format('d/m/Y') }} — {{ $trx->rental_end->format('d/m/Y') }} ({{ $trx->total_days }} hari)</div>
                <div><span class="text-gray-500">Item:</span> {{ $trx->items->count() }} item</div>
                <div class="text-right"><span class="text-gray-500">Total:</span> <span class="font-bold text-emerald-600">Rp {{ number_format($trx->total_cost,0,',','.') }}</span></div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('customer.transactions.show', $trx) }}" class="text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg font-medium transition">Detail</a>
                @if(in_array($trx->status, ['Menunggu Konfirmasi','Ditolak']) && !$trx->payment_proof)
                <a href="{{ route('customer.payment', $trx) }}" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg font-medium transition">Upload Pembayaran</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
