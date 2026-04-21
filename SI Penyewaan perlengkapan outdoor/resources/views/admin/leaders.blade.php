@extends('layouts.admin')
@section('page-title', 'Leader')
@section('content')
<div class="space-y-6" x-data="{ showAdd: false, editLeader: null }">
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-500">Kelola pemandu pendakian</p>
        <button @click="showAdd = true" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">+ Tambah Leader</button>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-900"><tr class="text-left text-xs text-gray-500"><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Telepon</th><th class="px-4 py-3">Alamat</th><th class="px-4 py-3">Fee/hari</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Aksi</th></tr></thead>
                <tbody>
                @foreach($leaders as $l)
                <tr class="border-t dark:border-gray-700">
                    <td class="px-4 py-3 font-medium dark:text-white">{{ $l->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $l->phone }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $l->address }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($l->fee_per_day,0,',','.') }}</td>
                    <td class="px-4 py-3"><span class="text-xs px-2 py-0.5 rounded-full {{ $l->is_active?'bg-emerald-100 text-emerald-700':'bg-red-100 text-red-700' }}">{{ $l->is_active?'Aktif':'Nonaktif' }}</span></td>
                    <td class="px-4 py-3">
                        <div class="flex gap-1">
                            <button @click="editLeader = {{ $l->toJson() }}" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-lg">Edit</button>
                            <form action="{{ route('admin.leaders.destroy', $l) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE') <button class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-lg">Hapus</button></form>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Add Modal --}}
    <div x-show="showAdd" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="absolute inset-0 bg-black/50" @click="showAdd = false"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="font-bold text-lg mb-4 dark:text-white">Tambah Leader</h3>
            <form action="{{ route('admin.leaders.store') }}" method="POST" class="space-y-3">@csrf
                <input type="text" name="name" placeholder="Nama" required class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <input type="text" name="phone" placeholder="Telepon" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <input type="text" name="address" placeholder="Alamat" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <input type="number" name="fee_per_day" placeholder="Fee per hari" required min="0" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <div class="flex gap-2"><button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-semibold flex-1">Simpan</button><button type="button" @click="showAdd = false" class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-lg text-sm flex-1">Batal</button></div>
            </form>
        </div>
    </div>
    {{-- Edit Modal --}}
    <div x-show="editLeader" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="absolute inset-0 bg-black/50" @click="editLeader = null"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="font-bold text-lg mb-4 dark:text-white">Edit Leader</h3>
            <form :action="'/admin/leaders/' + (editLeader?.id || '')" method="POST" class="space-y-3">@csrf @method('PUT')
                <input type="text" name="name" :value="editLeader?.name" required class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <input type="text" name="phone" :value="editLeader?.phone" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <input type="text" name="address" :value="editLeader?.address" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <input type="number" name="fee_per_day" :value="editLeader?.fee_per_day" required min="0" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <div class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" :checked="editLeader?.is_active" class="rounded"><label class="text-sm">Aktif</label></div>
                <div class="flex gap-2"><button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-semibold flex-1">Perbarui</button><button type="button" @click="editLeader = null" class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-lg text-sm flex-1">Batal</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
