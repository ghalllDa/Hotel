<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center w-full">

            <!-- KIRI: Kelola Hotel & Manajemen Pemesanan (hanya admin_operasional) -->
            <div class="flex items-center gap-4">
                @auth
                    @if(auth()->user()->role === 'admin_operasional')
                        <!-- Kelola Hotel -->
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-1 text-sm font-medium text-blue-700 hover:text-blue-900">
                                    Kelola Hotel
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('hotels.index')">🏨 Manajemen Hotel</x-dropdown-link>
                                <x-dropdown-link href="#">💸 Promo Kamar</x-dropdown-link>
                                <x-dropdown-link href="#">⚙️ Fasilitas Hotel</x-dropdown-link>
                                <x-dropdown-link href="#">🔄 Status Kamar</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <!-- Manajemen Pemesanan -->
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-1 text-sm font-medium text-blue-700 hover:text-blue-900">
                                    Manajemen Pemesanan
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link href="#">📋 Daftar Pesanan</x-dropdown-link>
                                <x-dropdown-link href="#">✅ Menyetujui Pemesanan</x-dropdown-link>
                                <x-dropdown-link href="#">❌ Menolak / Membatalkan</x-dropdown-link>
                                <x-dropdown-link href="#">💳 Status Pembayaran</x-dropdown-link>
                                <x-dropdown-link href="#">🔄 Proses Refund</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endif
                @endauth
            </div>

            <!-- KANAN: User / Admin Dropdown -->
            <div class="flex items-center gap-4">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                            {{ auth()->user()->name }}
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
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

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
