@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="font-display font-bold text-3xl dark:text-white">Katalog Perlengkapan</h1>
        <p class="text-gray-500 mt-1">Temukan perlengkapan outdoor yang Anda butuhkan untuk petualangan berikutnya.</p>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('gear.index') }}" class="flex flex-wrap gap-3 mb-8">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari perlengkapan..."
               class="flex-1 min-w-[200px] px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
        <select name="category" class="px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-2 focus:ring-emerald-500">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">Filter</button>
        @if(request()->hasAny(['search','category']))
        <a href="{{ route('gear.index') }}" class="px-5 py-2.5 rounded-xl border dark:border-gray-700 text-sm text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Reset</a>
        @endif
    </form>

    {{-- Grid --}}
    @if($gears->isEmpty())
    <div class="text-center py-16">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        <p class="text-gray-500">Tidak ada perlengkapan ditemukan.</p>
    </div>
    @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($gears as $gear)
        @include('components.gear-card', ['gear' => $gear])
        @endforeach
    </div>
    @endif
</div>
@endsection
