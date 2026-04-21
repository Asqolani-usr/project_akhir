{{-- Cart Sheet — Alpine.js slide-over panel --}}
<div x-data="cartSheet()" x-show="open" x-cloak @toggle-cart.window="open = !open" class="fixed inset-0 z-50">
    {{-- Overlay --}}
    <div x-show="open" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="open = false" class="absolute inset-0 bg-black/50"></div>

    {{-- Panel --}}
    <div x-show="open" x-transition:enter="transform transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
         class="absolute right-0 top-0 h-full w-full max-w-md bg-white dark:bg-gray-900 shadow-xl flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b dark:border-gray-800">
            <h2 class="font-display font-bold text-lg">Keranjang Sewa</h2>
            <button @click="open = false" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Items --}}
        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
            <template x-if="items.length === 0">
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <p class="text-sm">Keranjang kosong</p>
                </div>
            </template>
            <template x-for="item in items" :key="item.gear_id">
                <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-800 rounded-xl p-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm truncate" x-text="item.gear_name"></p>
                        <p class="text-xs text-gray-500" x-text="item.category"></p>
                        <p class="text-sm font-semibold text-emerald-600 mt-1" x-text="formatIDR(item.price_per_day) + '/hari'"></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="updateQty(item.gear_id, item.quantity - 1)" class="w-7 h-7 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-sm font-bold hover:bg-gray-300 transition">−</button>
                        <span class="w-6 text-center text-sm font-semibold" x-text="item.quantity"></span>
                        <button @click="updateQty(item.gear_id, item.quantity + 1)" class="w-7 h-7 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-sm font-bold hover:bg-gray-300 transition">+</button>
                    </div>
                    <button @click="removeItem(item.gear_id)" class="p-1 text-red-500 hover:text-red-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </template>
        </div>

        {{-- Footer --}}
        <div class="border-t dark:border-gray-800 px-6 py-4 space-y-3" x-show="items.length > 0">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Subtotal / hari</span>
                <span class="font-bold text-emerald-600" x-text="formatIDR(subtotalPerDay)"></span>
            </div>
            <a href="{{ route('checkout') }}" class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center py-3 rounded-xl font-semibold transition shadow-sm">Checkout</a>
            <button @click="clearCart()" class="block w-full text-sm text-red-500 hover:text-red-700 transition py-1">Kosongkan Keranjang</button>
        </div>
    </div>
</div>

<script>
function cartSheet() {
    return {
        open: false,
        items: [],
        subtotalPerDay: 0,
        init() {
            this.fetchCart();
            window.addEventListener('cart-updated', () => this.fetchCart());
        },
        async fetchCart() {
            try {
                const res = await fetch('/cart', { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } });
                const data = await res.json();
                this.items = data.items || [];
                this.subtotalPerDay = data.subtotal_per_day || 0;
                const badges = document.querySelectorAll('.cart-badge');
                badges.forEach(badge => {
                    badge.textContent = data.item_count || 0;
                    badge.classList.toggle('hidden', !data.item_count);
                });
            } catch (e) { console.error(e); }
        },
        async updateQty(gearId, qty) {
            if (qty < 1) return;
            await fetch('/cart/update', { method: 'PATCH', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body: JSON.stringify({ gear_id: gearId, quantity: qty }) });
            this.fetchCart();
        },
        async removeItem(gearId) {
            await fetch('/cart/remove', { method: 'DELETE', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body: JSON.stringify({ gear_id: gearId }) });
            this.fetchCart();
        },
        async clearCart() {
            await fetch('/cart/clear', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } });
            this.fetchCart();
        },
        formatIDR(val) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
        }
    };
}
</script>
