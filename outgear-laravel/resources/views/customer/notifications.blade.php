@extends('layouts.customer')
@section('customer-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="font-display font-bold text-2xl dark:text-white">Notifikasi</h2>
        @if($notifications->where('read', false)->count())
        <form action="{{ route('customer.notifications.readAll') }}" method="POST">@csrf <button class="text-sm text-emerald-600 hover:underline">Tandai semua dibaca</button></form>
        @endif
    </div>
    @if($notifications->isEmpty())
    <div class="text-center py-12"><p class="text-gray-500 text-sm">Belum ada notifikasi.</p></div>
    @else
    <div class="space-y-3">
        @foreach($notifications as $n)
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-4 flex items-start gap-3 {{ !$n->read ? 'border-l-4 border-l-emerald-500' : '' }}">
            <span class="text-xl flex-shrink-0">{{ $n->icon ?: '🔔' }}</span>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm dark:text-white">{{ $n->title }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $n->message }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $n->created_at->diffForHumans() }}</p>
            </div>
            <div class="flex gap-1 flex-shrink-0">
                @if(!$n->read)
                <form action="{{ route('customer.notifications.read', $n) }}" method="POST">@csrf @method('PATCH') <button class="text-xs text-emerald-600 hover:underline">Baca</button></form>
                @endif
                <form action="{{ route('customer.notifications.destroy', $n) }}" method="POST">@csrf @method('DELETE') <button class="text-xs text-red-500 hover:underline">Hapus</button></form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
