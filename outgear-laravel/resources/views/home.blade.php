@extends('layouts.app')
@section('content')
@php
$categoryIcons = ['Tenda'=>'⛺','Sleeping Bag'=>'🛏️','Carrier / Ransel'=>'🎒','Matras'=>'🟦','Kompor & Masak'=>'🔥','Penerangan'=>'🔦','Navigasi'=>'🧭','Safety & P3K'=>'🩹'];
$stats = [['label'=>'Item Tersedia','value'=>$gears->count().'+'],['label'=>'Pelanggan Puas','value'=>'1.2K+'],['label'=>'Lokasi Pendakian','value'=>'50+'],['label'=>'Tahun Berpengalaman','value'=>'5+']];
$howItWorks = [['step'=>'01','title'=>'Pilih Perlengkapan','desc'=>'Browse katalog lengkap kami dan pilih peralatan sesuai kebutuhan pendakian Anda.'],['step'=>'02','title'=>'Tentukan Tanggal','desc'=>'Pilih tanggal mulai dan selesai penyewaan, serta opsikan pemandu (leader).'],['step'=>'03','title'=>'Lakukan Pembayaran','desc'=>'Bayar via transfer bank dan upload bukti pembayaran di aplikasi.'],['step'=>'04','title'=>'Ambil & Nikmati','desc'=>'Ambil perlengkapan di lokasi kami dan mulai petualangan tak terlupakan!']];
$testimonials = [['name'=>'Rizky A.','location'=>'Bukit Pergasingan','rating'=>5,'text'=>'Pelayanan cepat, perlengkapan lengkap dan terawat. Proses sewa sangat mudah!'],['name'=>'Sinta W.','location'=>'Rinjani','rating'=>5,'text'=>'Leader yang disediakan sangat profesional dan berpengalaman. Recommended!'],['name'=>'Dedi M.','location'=>'Bukit Telunjuk','rating'=>4,'text'=>'Harga terjangkau, kondisi barang masih bagus. Pasti balik lagi.']];
@endphp

{{-- Hero --}}
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-800 via-teal-700 to-cyan-800">
    <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 80 80%22%3E%3Ccircle cx=%2240%22 cy=%2240%22 r=%222%22 fill=%22white%22 opacity=%220.3%22/%3E%3C/svg%3E');background-size:40px 40px;"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36 flex flex-col items-center text-center gap-6">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-sm text-white/80 font-medium animate-fade-in">
            🏔️ Rental Outdoor Terpercaya #1 di Rinjani
        </div>
        <h1 class="font-display font-bold text-4xl md:text-6xl text-white leading-tight max-w-3xl animate-fade-in">
            Petualangan Seru Dimulai dari <span class="text-amber-400">Perlengkapan Tepat</span>
        </h1>
        <p class="text-white/70 text-lg max-w-xl leading-relaxed animate-fade-in">
            Sewa peralatan outdoor berkualitas tinggi untuk mendaki gunung, camping, dan eksplorasi alam. Tersedia leader berpengalaman siap menemani perjalanan Anda.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 animate-fade-in">
            <a href="{{ route('gear.index') }}" class="bg-amber-500 hover:bg-amber-600 text-gray-900 px-6 py-3 rounded-xl font-semibold inline-flex items-center gap-2 transition shadow-lg">
                Lihat Perlengkapan <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            @guest
            <a href="{{ route('register') }}" class="border border-white text-white bg-white/15 hover:bg-white hover:text-emerald-800 px-6 py-3 rounded-xl font-semibold transition backdrop-blur-sm">Daftar Sekarang</a>
            @endguest
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gray-50 dark:bg-gray-950" style="clip-path: ellipse(55% 100% at 50% 100%)"></div>
</section>

{{-- Stats --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4 relative z-10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($stats as $s)
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 shadow-sm p-4 text-center hover:shadow-md transition">
            <p class="font-display font-bold text-2xl text-emerald-600">{{ $s['value'] }}</p>
            <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- Categories --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-emerald-600 text-sm font-semibold uppercase tracking-widest mb-1">Kategori</p>
            <h2 class="font-display font-bold text-2xl md:text-3xl dark:text-white">Semua Jenis Perlengkapan</h2>
        </div>
        <a href="{{ route('gear.index') }}" class="hidden sm:flex items-center gap-1 text-sm text-gray-500 hover:text-emerald-600 transition">Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-3">
        @foreach($categories as $cat)
        <a href="{{ route('gear.index', ['category' => $cat]) }}" class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-3 flex flex-col items-center gap-2 text-center hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all group">
            <span class="text-2xl group-hover:scale-110 transition-transform">{{ $categoryIcons[$cat] ?? '🏔️' }}</span>
            <span class="text-xs font-medium leading-tight">{{ $cat }}</span>
        </a>
        @endforeach
    </div>
</section>

{{-- Featured Gear --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-emerald-600 text-sm font-semibold uppercase tracking-widest mb-1">Populer</p>
            <h2 class="font-display font-bold text-2xl md:text-3xl dark:text-white">Perlengkapan Pilihan</h2>
        </div>
        <a href="{{ route('gear.index') }}" class="flex items-center gap-1 text-sm text-gray-500 hover:text-emerald-600 transition">Semua Item <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($featured as $gear)
        @include('components.gear-card', ['gear' => $gear])
        @endforeach
    </div>
</section>

{{-- How It Works --}}
<section class="mt-20 bg-gray-100 dark:bg-gray-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <p class="text-emerald-600 text-sm font-semibold uppercase tracking-widest mb-2">Prosedur</p>
            <h2 class="font-display font-bold text-2xl md:text-3xl dark:text-white">Cara Sewa Perlengkapan</h2>
            <p class="text-gray-500 mt-2 max-w-md mx-auto">Prosedur penyewaan sederhana, transparan, dan aman.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($howItWorks as $step)
            <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-6 relative group hover:border-emerald-500 transition-colors">
                <div class="text-4xl font-display font-black text-emerald-600/15 group-hover:text-emerald-600/25 transition-colors mb-3">{{ $step['step'] }}</div>
                <h3 class="font-display font-semibold mb-2 dark:text-white">{{ $step['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
    <div class="text-center mb-10">
        <p class="text-emerald-600 text-sm font-semibold uppercase tracking-widest mb-2">Testimoni</p>
        <h2 class="font-display font-bold text-2xl md:text-3xl dark:text-white">Kata Mereka</h2>
    </div>
    <div class="grid sm:grid-cols-3 gap-5">
        @foreach($testimonials as $t)
        <div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-5 shadow-sm">
            <div class="flex gap-0.5 mb-3">
                @for($i = 0; $i < $t['rating']; $i++)
                <svg class="w-4 h-4 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-300 mb-4">"{{ $t['text'] }}"</p>
            <div class="flex items-center gap-2 text-sm">
                <div class="w-7 h-7 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                    <span class="text-emerald-700 dark:text-emerald-300 font-semibold text-xs">{{ substr($t['name'],0,1) }}</span>
                </div>
                <div>
                    <p class="font-semibold text-xs dark:text-white">{{ $t['name'] }}</p>
                    <p class="text-gray-400 text-xs flex items-center gap-1">📍 {{ $t['location'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- CTA --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
    <div class="bg-gradient-to-br from-emerald-800 via-teal-700 to-cyan-800 rounded-2xl p-10 text-center flex flex-col items-center gap-5">
        <span class="text-4xl">🛡️</span>
        <h2 class="font-display font-bold text-2xl md:text-3xl text-white max-w-lg">Siap Memulai Petualangan Anda?</h2>
        <p class="text-white/70 max-w-md text-sm">Daftar sekarang dan dapatkan akses ke ratusan perlengkapan outdoor berkualitas.</p>
        @guest
        <a href="{{ route('register') }}" class="bg-amber-500 hover:bg-amber-600 text-gray-900 px-6 py-3 rounded-xl font-semibold inline-flex items-center gap-2 transition shadow-lg">
            Mulai Sewa Sekarang <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
        @endguest
    </div>
</section>
@endsection
