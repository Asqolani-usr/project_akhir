@extends('layouts.app')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="text-4xl mb-3 block">🏔️</span>
            <h1 class="font-display font-bold text-2xl dark:text-white">Daftar di Mangku Rinjani</h1>
            <p class="text-gray-500 text-sm mt-1">Buat akun untuk mulai menyewa perlengkapan outdoor.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700 shadow-sm p-6">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="081234567890"
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Alamat</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Kota / Alamat"
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-xl font-semibold transition shadow-sm text-sm">
                    Daftar
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-emerald-600 font-semibold hover:underline">Login</a>
        </p>
    </div>
</div>
@endsection
