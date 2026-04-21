@extends('layouts.customer')
@section('customer-content')
<div class="space-y-6">
    <h2 class="font-display font-bold text-2xl dark:text-white">Dashboard</h2>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-4">
            <p class="text-2xl font-bold text-emerald-600">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Transaksi</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-4">
            <p class="text-2xl font-bold text-amber-600">{{ $stats['active'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Aktif</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-4">
            <p class="text-2xl font-bold text-blue-600">{{ $stats['completed'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Selesai</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-4">
            <p class="text-2xl font-bold text-teal-600">Rp {{ number_format($stats['total_spent'],0,',','.') }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Pengeluaran</p>
        </div>
    </div>

    {{-- Recent --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5">
        <h3 class="font-semibold dark:text-white mb-4">Transaksi Terbaru</h3>
        @if($recentTransactions->isEmpty())
        <p class="text-gray-500 text-sm">Belum ada transaksi.</p>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-xs text-gray-500 border-b dark:border-gray-700"><th class="pb-2">Kode</th><th class="pb-2">Tanggal</th><th class="pb-2">Status</th><th class="pb-2 text-right">Total</th></tr></thead>
                <tbody>
                @foreach($recentTransactions as $trx)
                <tr class="border-b dark:border-gray-700/50">
                    <td class="py-3 font-mono text-xs">{{ $trx->code }}</td>
                    <td class="py-3 text-gray-500">{{ $trx->rental_start->format('d/m/Y') }}</td>
                    <td class="py-3">
                        @php $statusColors = ['Menunggu Konfirmasi'=>'bg-yellow-100 text-yellow-700','Dikonfirmasi'=>'bg-blue-100 text-blue-700','Dipinjam'=>'bg-purple-100 text-purple-700','Dikembalikan'=>'bg-teal-100 text-teal-700','Selesai'=>'bg-emerald-100 text-emerald-700','Ditolak'=>'bg-red-100 text-red-700','Terlambat'=>'bg-orange-100 text-orange-700']; @endphp
                        <span class="text-xs px-2 py-1 rounded-full font-medium {{ $statusColors[$trx->status] ?? 'bg-gray-100' }}">{{ $trx->status }}</span>
                    </td>
                    <td class="py-3 text-right font-semibold">Rp {{ number_format($trx->total_cost,0,',','.') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
