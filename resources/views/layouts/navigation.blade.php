<nav x-data="{ sidebarOpen: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- KIRI: HAMBURGER -->
            <div class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->role === 'admin_operasional')
                        <button
                            @click="sidebarOpen = true"
                            class="p-2 rounded-md text-blue-700 hover:bg-blue-100 focus:outline-none">
                            <!-- ICON HAMBURGER -->
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    @endif
                @endauth

                <span class="font-semibold text-blue-700">
                    Dashboard
                </span>
            </div>

            <!-- KANAN: USER -->
            <div class="flex items-center gap-4">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                                {{ auth()->user()->name }}
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
                                <x-dropdown-link :href="route('logout')"
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
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-40 z-40">
    </div>

    <!-- SIDEBAR -->
    <aside
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 w-72 h-full bg-white shadow-lg z-50 overflow-y-auto">

        <!-- HEADER SIDEBAR -->
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="font-bold text-lg text-blue-700">
                Menu Admin
            </h2>
            <button @click="sidebarOpen = false">
                ✖
            </button>
        </div>

        <!-- MENU -->
        <div class="p-4 space-y-4 text-sm">

            <!-- KELOLA HOTEL -->
            <div>
                <p class="font-semibold text-gray-700 mb-2">Kelola Hotel</p>
                <ul class="space-y-2 ml-2">
                    <li>
                        <a href="{{ route('hotels.index') }}" class="block hover:text-blue-600">
                            🏨 Manajemen Hotel
                        </a>
                    </li>
                    <li>
                        
    <a href="{{ route('promo.index') }}"
       class="block hover:text-blue-600">
        💸 Promo Kamar
    </a>

                    </li>
                    <li>
                        <a href="#" class="block hover:text-blue-600">
                            ⚙️ Fasilitas Hotel
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block hover:text-blue-600">
                            🔄 Status Kamar
                        </a>
                    </li>
                </ul>
            </div>

            <!-- PEMESANAN -->
            <div>
                <p class="font-semibold text-gray-700 mb-2">Manajemen Pemesanan</p>
                <ul class="space-y-2 ml-2">
                    <li>📋 Daftar Pesanan</li>
                    <li>✅ Menyetujui Pemesanan</li>
                    <li>❌ Pembatalan</li>
                    <li>💳 Status Pembayaran</li>
                </ul>
            </div>

            <!-- KONTEN -->
            <div>
                <p class="font-semibold text-gray-700 mb-2">Konten</p>
                <ul class="space-y-2 ml-2">
                    <li>📝 Review & Komentar</li>
                    <li>🎁 Fasilitas & Promo</li>
                    <li>🔔 Notifikasi Admin</li>
                </ul>
            </div>

        </div>
    </aside>
</nav>
