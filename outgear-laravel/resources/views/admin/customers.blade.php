@extends('layouts.admin')
@section('page-title', 'Pelanggan')
@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900"><tr class="text-left text-xs text-gray-500"><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Email</th><th class="px-4 py-3">Telepon</th><th class="px-4 py-3">Alamat</th><th class="px-4 py-3">Bergabung</th><th class="px-4 py-3">Transaksi</th></tr></thead>
            <tbody>
            @foreach($customers as $c)
            <tr class="border-t dark:border-gray-700">
                <td class="px-4 py-3 font-medium dark:text-white">{{ $c->name }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $c->email }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $c->phone ?: '—' }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $c->address ?: '—' }}</td>
                <td class="px-4 py-3 text-xs text-gray-500">{{ $c->join_date->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-center">{{ $c->total_transactions }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
