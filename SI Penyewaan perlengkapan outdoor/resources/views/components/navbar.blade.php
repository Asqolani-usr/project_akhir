<nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-800 sticky top-0 z-40"
     x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Mangku Rinjani" class="h-14 w-auto object-contain drop-shadow-sm">
                </a>
            </div>

            {{-- Desktop nav --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm font-medium hover:text-emerald-600 transition {{ request()->routeIs('home') ? 'text-emerald-600' : '' }}">Beranda</a>
                <a href="{{ route('gear.index') }}" class="text-sm font-medium hover:text-emerald-600 transition {{ request()->routeIs('gear.*') ? 'text-emerald-600' : '' }}">Perlengkapan</a>

                {{-- Cart button (hide for admin) --}}
                @if(!auth()->check() || !auth()->user()->isAdmin())
                <button @click="$dispatch('toggle-cart')" class="relative p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <span class="cart-badge absolute -top-1 -right-1 bg-emerald-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold hidden">0</span>
                </button>
                @endif

                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium hover:text-emerald-600 transition">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                                <span class="text-emerald-700 dark:text-emerald-300 font-semibold text-xs">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            {{ auth()->user()->name }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border dark:border-gray-700 py-1 z-50">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Dashboard Admin</a>
                            @else
                                <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Dashboard</a>
                                <a href="{{ route('customer.transactions') }}" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Transaksi Saya</a>
                                <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Profil</a>
                            @endif
                            <hr class="my-1 dark:border-gray-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50 dark:hover:bg-gray-700">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-emerald-600 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">Daftar</a>
                @endauth

                {{-- Dark mode --}}
                <button @click="darkMode = !darkMode" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>
            </div>

            {{-- Mobile hamburger --}}
            <div class="flex items-center gap-2 md:hidden">
                @if(!auth()->check() || !auth()->user()->isAdmin())
                <button @click="$dispatch('toggle-cart')" class="relative p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <span class="cart-badge absolute -top-1 -right-1 bg-emerald-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold hidden">0</span>
                </button>
                @endif
                <button @click="mobileOpen = !mobileOpen" class="p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileOpen" x-transition class="md:hidden border-t dark:border-gray-800 bg-white dark:bg-gray-900 px-4 py-3 space-y-2">
        <a href="{{ route('home') }}" class="block py-2 text-sm font-medium">Beranda</a>
        <a href="{{ route('gear.index') }}" class="block py-2 text-sm font-medium">Perlengkapan</a>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block py-2 text-sm font-medium">Dashboard Admin</a>
            @else
                <a href="{{ route('customer.dashboard') }}" class="block py-2 text-sm font-medium">Dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}"><@csrf><button type="submit" class="block py-2 text-sm text-red-600">Logout</button></form>
        @else
            <a href="{{ route('login') }}" class="block py-2 text-sm font-medium">Login</a>
            <a href="{{ route('register') }}" class="block py-2 text-sm font-semibold text-emerald-600">Daftar</a>
        @endauth
    </div>
</nav>
