@extends('layouts.admin')
@section('page-title', 'Dashboard')
@section('content')
<div class="space-y-6">
    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php $statItems = [['label'=>'Total Gear','value'=>$stats['total_gear'],'icon'=>'📦','color'=>'emerald'],['label'=>'Pelanggan','value'=>$stats['total_customers'],'icon'=>'👥','color'=>'blue'],['label'=>'Transaksi Aktif','value'=>$stats['active_transactions'],'icon'=>'📋','color'=>'amber'],['label'=>'Pendapatan','value'=>'Rp '.number_format($stats['total_revenue'],0,',','.'),'icon'=>'💰','color'=>'teal']]; @endphp
        @foreach($statItems as $s)
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-4">
            <div class="flex items-center gap-2 mb-2"><span class="text-xl">{{ $s['icon'] }}</span><span class="text-xs text-gray-500">{{ $s['label'] }}</span></div>
            <p class="text-2xl font-bold text-{{ $s['color'] }}-600">{{ $s['value'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Recent Transactions --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-4"><h3 class="font-semibold dark:text-white">Transaksi Terbaru</h3><a href="{{ route('admin.transactions') }}" class="text-xs text-emerald-600 hover:underline">Lihat semua →</a></div>
            @forelse($recentTransactions as $trx)
            <div class="flex items-center justify-between py-2 border-b dark:border-gray-700/50 last:border-0 text-sm">
                <div><p class="font-mono text-xs dark:text-white">{{ $trx->code }}</p><p class="text-xs text-gray-500">{{ $trx->customer_name }}</p></div>
                @php $sc=['Menunggu Konfirmasi'=>'text-yellow-600','Dikonfirmasi'=>'text-blue-600','Dipinjam'=>'text-purple-600','Selesai'=>'text-emerald-600','Ditolak'=>'text-red-600']; @endphp
                <span class="text-xs font-medium {{ $sc[$trx->status] ?? '' }}">{{ $trx->status }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-500">Belum ada transaksi.</p>
            @endforelse
        </div>

        {{-- Low Stock --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-4"><h3 class="font-semibold dark:text-white">⚠️ Stok Rendah</h3></div>
            @forelse($lowStockGear as $g)
            <div class="flex items-center justify-between py-2 border-b dark:border-gray-700/50 last:border-0 text-sm">
                <div><p class="dark:text-white">{{ $g->name }}</p><p class="text-xs text-gray-500">{{ $g->category }}</p></div>
                <span class="text-xs font-bold text-red-600">Stok: {{ $g->stock }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-500">Semua stok aman. 👍</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
