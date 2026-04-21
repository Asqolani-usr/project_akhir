{{-- Gear Card Component --}}
<div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 overflow-hidden shadow-sm hover:shadow-lg transition-all group {{ $gear->stock <= 0 ? 'opacity-75' : '' }}">
    <div class="aspect-[4/3] bg-gray-100 dark:bg-gray-700 relative overflow-hidden">
        @if($gear->image_url)
            <img src="{{ $gear->image_url }}" alt="{{ $gear->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        @endif
        <div class="absolute top-2 left-2">
            <span class="bg-emerald-600/90 text-white text-xs px-2 py-1 rounded-lg font-medium backdrop-blur-sm">{{ $gear->category }}</span>
        </div>
        @if($gear->stock <= 0)
        <div class="absolute top-2 right-2">
            <span class="bg-red-600/90 text-white text-xs px-2 py-1 rounded-lg font-medium backdrop-blur-sm">Stok Habis</span>
        </div>
        @elseif($gear->condition !== 'Baik')
        <div class="absolute top-2 right-2">
            <span class="bg-amber-500/90 text-white text-xs px-2 py-1 rounded-lg font-medium backdrop-blur-sm">{{ $gear->condition }}</span>
        </div>
        @endif
    </div>
    <div class="p-4">
        <h3 class="font-semibold text-sm dark:text-white truncate">{{ $gear->name }}</h3>
        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $gear->description }}</p>
        <div class="flex items-center justify-between mt-3">
            <div>
                <p class="text-emerald-600 font-bold text-sm">Rp {{ number_format($gear->price_per_day, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400">/ hari</p>
            </div>
            @if(auth()->check() && auth()->user()->isAdmin())
                {{-- Do not show any buttons for admin --}}
            @elseif($gear->stock > 0)
            <button onclick="addToCart({{ $gear->id }})"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-lg text-xs font-semibold transition inline-flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Sewa
            </button>
            @else
            <span class="bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 px-3 py-2 rounded-lg text-xs font-semibold cursor-not-allowed">
                Habis
            </span>
            @endif
        </div>
        <div class="flex items-center justify-between mt-2 text-xs text-gray-400">
            <span>Stok: {{ $gear->stock }}</span>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
async function addToCart(gearId) {
    try {
        const res = await fetch('/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
            body: JSON.stringify({ gear_id: gearId, quantity: 1 })
        });
        const data = await res.json();
        if (res.ok) {
            window.dispatchEvent(new Event('cart-updated'));
            // Remove alert or toggle-cart to silently add
        } else {
            alert(data.message || 'Gagal menambahkan ke keranjang.');
        }
    } catch(e) { console.error(e); }
}
</script>
@endpush
@endonce
