@extends('layouts.admin')
@section('page-title', 'Transaksi')
@section('content')
<div class="space-y-6" x-data="{ actionTrx: null, actionType: '' }">
    <form method="GET" class="flex flex-wrap gap-2">
        <a href="{{ route('admin.transactions') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium border transition {{ !request('status')?'bg-emerald-600 text-white border-emerald-600':'dark:border-gray-700' }}">Semua</a>
        @foreach(\App\Models\Transaction::STATUSES as $s)
        <a href="{{ route('admin.transactions', ['status'=>$s]) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium border transition {{ request('status')===$s?'bg-emerald-600 text-white border-emerald-600':'dark:border-gray-700 hover:bg-gray-100' }}">{{ $s }}</a>
        @endforeach
    </form>

    <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-900"><tr class="text-left text-xs text-gray-500"><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Pelanggan</th><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Bayar</th><th class="px-4 py-3 text-right">Total</th><th class="px-4 py-3">Aksi</th></tr></thead>
                <tbody>
                @foreach($transactions as $trx)
                <tr class="border-t dark:border-gray-700">
                    <td class="px-4 py-3 font-mono text-xs dark:text-white">{{ $trx->code }}</td>
                    <td class="px-4 py-3">{{ $trx->customer_name }}</td>
                    <td class="px-4 py-3 text-xs text-gray-500">{{ $trx->rental_start->format('d/m') }}–{{ $trx->rental_end->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        @php $sc=['Menunggu Konfirmasi'=>'bg-yellow-100 text-yellow-700','Dikonfirmasi'=>'bg-blue-100 text-blue-700','Dipinjam'=>'bg-purple-100 text-purple-700','Selesai'=>'bg-emerald-100 text-emerald-700','Ditolak'=>'bg-red-100 text-red-700','Terlambat'=>'bg-orange-100 text-orange-700','Dikembalikan'=>'bg-teal-100 text-teal-700']; @endphp
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $sc[$trx->status]??'' }}">{{ $trx->status }}</span>
                        @if($trx->stock_reduced)
                            <span class="text-xs px-1.5 py-0.5 rounded-full bg-amber-100 text-amber-700 ml-1" title="Stok sudah dikurangi">📦 Stok ↓</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($trx->payment_proof)
                        <a href="{{ $trx->payment_proof_url }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat</a>
                        @else<span class="text-xs text-gray-400">—</span>@endif
                    </td>
                    <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($trx->total_cost,0,',','.') }}</td>
                    <td class="px-4 py-3">
                        <button @click="actionTrx = {{ $trx->toJson() }}; actionType = ''" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-lg">Update</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Update Status Modal --}}
    <div x-show="actionTrx" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="absolute inset-0 bg-black/50" @click="actionTrx = null"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="font-bold text-lg mb-4 dark:text-white">Update Status</h3>
            <p class="text-sm text-gray-500 mb-4">Transaksi: <span class="font-mono" x-text="actionTrx?.code"></span></p>
            <form :action="'/admin/transactions/' + (actionTrx?.id || '') + '/status'" method="POST" class="space-y-3">@csrf @method('PUT')
                <select name="status" x-model="actionType" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 text-sm bg-white dark:bg-gray-900">
                    @foreach(\App\Models\Transaction::STATUSES as $s)<option value="{{ $s }}">{{ $s }}</option>@endforeach
                </select>
                <div x-show="actionType === 'Ditolak'">
                    <textarea name="rejection_reason" placeholder="Alasan penolakan..." class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 text-sm bg-white dark:bg-gray-900" rows="2"></textarea>
                </div>
                <div x-show="actionType === 'Dikembalikan' || actionType === 'Selesai'">
                    <label class="text-sm font-medium">Tanggal Kembali</label>
                    <input type="date" name="return_date" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 text-sm bg-white dark:bg-gray-900">
                </div>
                <div class="flex gap-2"><button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-semibold flex-1">Simpan</button><button type="button" @click="actionTrx = null" class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-lg text-sm flex-1">Batal</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
