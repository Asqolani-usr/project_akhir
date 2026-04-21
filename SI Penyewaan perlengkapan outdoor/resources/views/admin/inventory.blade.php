@extends('layouts.admin')
@section('page-title', 'Inventaris')
@section('content')
<div class="space-y-6" x-data="{ showAdd: false, editGear: null }">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari gear..." class="px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-800 text-sm w-48">
            <select name="category" class="px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                <option value="">Semua</option>@foreach($categories as $c)<option value="{{ $c }}" {{ request('category')==$c?'selected':'' }}>{{ $c }}</option>@endforeach
            </select>
            <button class="bg-gray-200 dark:bg-gray-700 px-3 py-2 rounded-lg text-sm">Filter</button>
        </form>
        <button @click="showAdd = true" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">+ Tambah Gear</button>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-900"><tr class="text-left text-xs text-gray-500"><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Harga/hari</th><th class="px-4 py-3">Stok</th><th class="px-4 py-3">Kondisi</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Aksi</th></tr></thead>
                <tbody>
                @foreach($gears as $gear)
                <tr class="border-t dark:border-gray-700">
                    <td class="px-4 py-3 font-medium dark:text-white">{{ $gear->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $gear->category }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($gear->price_per_day,0,',','.') }}</td>
                    <td class="px-4 py-3">{{ $gear->stock }}</td>
                    <td class="px-4 py-3"><span class="text-xs px-2 py-0.5 rounded-full {{ $gear->condition==='Baik'?'bg-emerald-100 text-emerald-700':($gear->condition==='Cukup'?'bg-yellow-100 text-yellow-700':'bg-red-100 text-red-700') }}">{{ $gear->condition }}</span></td>
                    <td class="px-4 py-3"><span class="text-xs px-2 py-0.5 rounded-full {{ $gear->is_available?'bg-emerald-100 text-emerald-700':'bg-red-100 text-red-700' }}">{{ $gear->is_available?'Tersedia':'Tidak' }}</span></td>
                    <td class="px-4 py-3">
                        <div class="flex gap-1">
                            <button @click="editGear = {{ $gear->toJson() }}" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-lg hover:bg-blue-200 transition">Edit</button>
                            <form action="{{ route('admin.inventory.destroy', $gear) }}" method="POST" onsubmit="return confirm('Hapus gear ini?')">@csrf @method('DELETE') <button class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-lg hover:bg-red-200 transition">Hapus</button></form>
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
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6">
            <h3 class="font-display font-bold text-lg mb-4 dark:text-white">Tambah Gear Baru</h3>
            <form action="{{ route('admin.inventory.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="text" name="name" placeholder="Nama Gear" required class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <input type="text" name="category" placeholder="Kategori" required class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <div class="grid grid-cols-2 gap-3">
                    <input type="number" name="price_per_day" placeholder="Harga/hari" required min="0" class="px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                    <input type="number" name="stock" placeholder="Stok" required min="0" class="px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                </div>
                <select name="condition" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm"><option value="Baik">Baik</option><option value="Cukup">Cukup</option><option value="Rusak">Rusak</option></select>
                <textarea name="description" placeholder="Deskripsi" rows="2" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm"></textarea>
                <input type="file" name="image" accept="image/*" class="w-full text-sm">
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex-1">Simpan</button>
                    <button type="button" @click="showAdd = false" class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-lg text-sm transition flex-1">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div x-show="editGear" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="absolute inset-0 bg-black/50" @click="editGear = null"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6">
            <h3 class="font-display font-bold text-lg mb-4 dark:text-white">Edit Gear</h3>
            <form :action="'/admin/inventory/' + (editGear?.id || '')" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf @method('PUT')
                <input type="text" name="name" :value="editGear?.name" required class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <input type="text" name="category" :value="editGear?.category" required class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                <div class="grid grid-cols-2 gap-3">
                    <input type="number" name="price_per_day" :value="editGear?.price_per_day" required min="0" class="px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                    <input type="number" name="stock" :value="editGear?.stock" required min="0" class="px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                </div>
                <select name="condition" :value="editGear?.condition" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm">
                    <template x-for="c in ['Baik','Cukup','Rusak']"><option :value="c" :selected="editGear?.condition === c" x-text="c"></option></template>
                </select>
                <div class="flex items-center gap-2"><input type="checkbox" name="is_available" value="1" :checked="editGear?.is_available" class="rounded"><label class="text-sm">Tersedia</label></div>
                <textarea name="description" rows="2" :value="editGear?.description" class="w-full px-3 py-2 rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm" x-text="editGear?.description"></textarea>
                <input type="file" name="image" accept="image/*" class="w-full text-sm">
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex-1">Perbarui</button>
                    <button type="button" @click="editGear = null" class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-lg text-sm transition flex-1">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
