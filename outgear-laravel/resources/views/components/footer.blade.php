<footer class="bg-gray-900 text-gray-400 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Mangku Rinjani" class="h-14 w-auto object-contain">
                    <span class="font-display font-bold text-xl text-white">Mangku Rinjani</span>
                </div>
                <p class="text-sm leading-relaxed max-w-md">Mangku Rinjani merupakan usaha penyewaan perlengkapan outdoor yang menyediakan berbagai kebutuhan kegiatan alam terbuka seperti tenda, carrier, sleeping bag, kompor portable, dan perlengkapan pendukung lainnya.</p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Link Cepat</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Beranda</a></li>
                    <li><a href="{{ route('gear.index') }}" class="hover:text-emerald-400 transition">Perlengkapan</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-emerald-400 transition">Daftar</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Login</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Kontak</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2">📍 Desa Karang Baru, Jalan Segara Anak, Kecamatan Wanasaba</li>
                    <li class="flex items-center gap-2">📞 081234567890</li>
                    <li class="flex items-center gap-2">📧 info@mangkurinjani.id</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-6 text-center text-xs">
            <p>&copy; {{ date('Y') }} Mangku Rinjani. All rights reserved.</p>
        </div>
    </div>
</footer>
