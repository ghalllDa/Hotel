<nav x-data="{ sidebarOpen: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- LEFT -->
            <div class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->role === 'admin_operasional')
                        <button
                            @click="sidebarOpen = true"
                            class="p-2 rounded-lg text-blue-700 hover:bg-blue-100 transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    @endif
                @endauth

                 @auth
                <span class="font-extrabold text-blue-700 text-lg tracking-wide">
                    HOME
                </span>
               
             
                @if(auth()->user()->role === 'user')
                    <x-nav-link :href="route('bookmark.index')" :active="request()->routeIs('bookmark.*')">
                        SAVE
                    </x-nav-link>
                @endif
            @endauth

            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-4">
                @auth

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 text-sm font-medium text-gray-700 hover:text-gray-900 transition">
                                <img
                                    class="h-9 w-9 rounded-full object-cover ring-2 ring-blue-300 shadow"
                                    src="{{ auth()->user()->profile_photo
                                        ? asset('storage/' . auth()->user()->profile_photo)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                    alt="{{ auth()->user()->name }}">
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link
                                    :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>
        </div>
    </div>

    <!-- OVERLAY -->
    <div x-show="sidebarOpen"
         x-transition.opacity
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40"></div>

    <!-- SIDEBAR -->
    <aside
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 w-72 h-full
               bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900
               text-gray-200 shadow-2xl z-50 overflow-y-auto">

        <!-- SIDEBAR HEADER -->
        <div class="p-6 border-b border-white/10">
            <h2 class="text-xl font-extrabold text-white tracking-wide">
                🛠 Administrator
            </h2>
            <p class="text-xs text-gray-400 mt-1">Hotel Management System</p>
        </div>

        <!-- MENU -->
        <div class="p-5 space-y-6 text-sm">

            <!-- HOTEL -->
            <div>
                <p class="text-xs uppercase tracking-widest text-gray-400 mb-3">
                    Hotel
                </p>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('hotels.index') }}"
                           class="menu-item {{ request()->routeIs('hotels.*') ? 'active-menu' : '' }}">
                            🏨 Manajemen Hotel
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('promo.index') }}"
                           class="menu-item {{ request()->routeIs('promo.*') ? 'active-menu' : '' }}">
                            💸 Promo Kamar
                        </a>
                    </li>
                </ul>
            </div>

            <!-- BOOKING -->
            <div>
                <p class="text-xs uppercase tracking-widest text-gray-400 mb-3">
                    Pemesanan
                </p>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.bookings.index') }}"
                           class="menu-item {{ request()->routeIs('admin.bookings.*') ? 'active-menu' : '' }}">
                            📋 Daftar Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bookings.index') }}?status=approved"
                           class="menu-item">
                            ✅ Disetujui
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bookings.index') }}?status=refund"
                           class="menu-item">
                            ❌ Pembatalan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- FOOTER -->
            <div class="pt-6 border-t border-white/10 text-xs text-gray-400 text-center">
                © {{ date('Y') }} Hotel System  
            </div>

        </div>
    </aside>

    <!-- STYLE KHUSUS (TANPA GANGGU KODE LAMA) -->
    <style>
        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background: rgba(59, 130, 246, 0.18);
            color: #fff;
            transform: translateX(4px);
        }

        .active-menu {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.45);
        }
    </style>
</nav>
