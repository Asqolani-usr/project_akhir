@extends('layouts.customer')
@section('customer-content')
<div class="space-y-6">
    <h2 class="font-display font-bold text-2xl dark:text-white">Edit Profil</h2>
    <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-6">
        <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4 max-w-lg">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1 dark:text-white">Nama</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 dark:text-white">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-sm cursor-not-allowed text-gray-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 dark:text-white">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 dark:text-white">Alamat</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2.5 rounded-xl border dark:border-gray-700 bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-emerald-500">{{ old('address', auth()->user()->address) }}</textarea>
            </div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
