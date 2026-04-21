@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        {{-- Sidebar nav --}}
        <aside class="w-full md:w-56 shrink-0">
            <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-4 sticky top-20">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b dark:border-gray-700">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                        <span class="text-emerald-700 dark:text-emerald-300 font-bold">{{ substr(auth()->user()->name,0,1) }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-sm dark:text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('customer.dashboard') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">📊 Dashboard</a>
                    <a href="{{ route('customer.transactions') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('customer.transactions*') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">📋 Transaksi</a>
                    @php $unreadCount = auth()->user()->notifications()->where('read', false)->count(); @endphp
                    <a href="{{ route('customer.notifications') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('customer.notifications') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                        <div class="flex items-center gap-2">
                            <span>🔔</span> Notifikasi
                        </div>
                        @if($unreadCount > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('customer.profile') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('customer.profile') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}">👤 Profil</a>
                </nav>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 min-w-0">
            @yield('customer-content')
        </div>
    </div>
</div>
@endsection
