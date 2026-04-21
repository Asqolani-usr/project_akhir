@extends('layouts.app')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="text-4xl mb-3 block">🏔️</span>
            <h1 class="font-display font-bold text-2xl dark:text-white">Masuk ke Mangku Rinjani</h1>
            <p class="text-gray-500 text-sm mt-1">Masuk untuk mengelola penyewaan Anda.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700 shadow-sm p-6 space-y-4">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-white">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        Ingat saya
                    </label>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-xl font-semibold transition shadow-sm text-sm">
                    Login
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-600 font-semibold hover:underline">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection
