<x-app-layout>

    <div class="max-w-7xl mx-auto px-6 py-6">

        {{-- WRAPPER AGAR BUTTON KE KANAN --}}
        <div class="flex justify-end">
            {{-- BUTTON KEMBALI --}}
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 mb-6
                      px-4 py-2
                      bg-blue-600 text-white
                      text-sm font-semibold
                      rounded-lg
                      shadow
                      hover:bg-blue-700
                      transition">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>

                Kembali ke Dashboard
            </a>
        </div>

        {{-- BANNER HOTEL --}}
        <div class="relative h-[320px] rounded-xl overflow-hidden mb-6" style="background-image: url('{{ optional($hotel->images->first())->path
            ? asset('storage/' . $hotel->images->first()->path)
            : asset('img/no-image.png') }}');
            background-size: cover;
            background-position: center;">

            <div class="absolute inset-0 bg-black/40"></div>

            <div class="absolute bottom-6 left-6 text-white">
                <h2 class="text-2xl font-bold">{{ $hotel->nama_hotel }}</h2>
                <div class="text-yellow-400 text-lg mb-1">
                    {{ str_repeat('⭐', $hotel->stars) }}
                </div>

                <p class="mb-4">{{ $hotel->lokasi }}</p>

                <a href="{{ route('hotels.rooms.create', $hotel->id) }}" class="inline-flex items-center gap-2
                          bg-blue-600 hover:bg-blue-700
                          px-4 py-2 rounded-lg
                          text-sm font-semibold shadow">
                    ➕ Tambah Kamar
                </a>
            </div>
        </div>

        {{-- DAFTAR KAMAR --}}
        <h3 class="text-lg font-bold mb-4">Daftar Kamar</h3>

        @if($hotel->rooms->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-data="{ open: false, action: '' }">

                @foreach($hotel->rooms as $room)
                    @php
                        $promo = $room->promos->first();
                        $hargaDiskon = $promo
                            ? $room->harga - ($room->harga * $promo->diskon / 100)
                            : null;
                    @endphp

                    <div class="bg-white rounded-lg shadow p-4 relative">

                        {{-- BADGE PROMO --}}
                        @if($promo)
                            <span class="absolute top-3 right-3
                                         bg-red-600 text-white
                                         text-xs font-bold
                                         px-3 py-1 rounded-full shadow">
                                Promo {{ $promo->diskon }}%
                            </span>
                        @endif

                        {{-- FOTO KAMAR --}}
                        @if($room->gambar)
                            <img src="{{ asset('storage/' . $room->gambar) }}"
                                 class="w-full h-40 object-cover rounded mb-3">
                        @endif

                        <h4 class="font-semibold text-lg">{{ $room->nama_kamar }}</h4>

                        {{-- HARGA --}}
                        <p class="text-sm mt-1">
                            <strong>Harga:</strong><br>

                            @if($promo)
                                <span class="text-gray-400 line-through text-sm">
                                    Rp {{ number_format($room->harga, 0, ',', '.') }}
                                </span><br>
                                <span class="text-red-600 font-bold">
                                    Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                                </span>
                            @else
                                Rp {{ number_format($room->harga, 0, ',', '.') }}
                            @endif
                        </p>

                        <p class="text-sm mt-1">
                            <strong>Status:</strong>
                            <span class="px-2 py-1 rounded text-xs
                                {{ $room->status == 'tersedia'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-200 text-gray-700' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </p>

                        <p class="text-sm mt-1">
                            <strong>Kapasitas:</strong>
                            👤 {{ $room->capacity }} Orang
                        </p>

                        <p class="text-sm mt-2">
                            <strong>Fasilitas:</strong><br>
                            {{ is_array($room->fasilitas) ? implode(', ', $room->fasilitas) : '-' }}
                        </p>

                        {{-- TOMBOL --}}
                        <div class="flex gap-2 mt-3">

                            <a href="{{ route('hotels.rooms.edit', [$hotel->id, $room->id]) }}"
                               class="inline-block px-3 py-1.5
                                      bg-yellow-500 hover:bg-yellow-600
                                      text-white text-sm rounded">
                                ✏️ Edit Kamar
                            </a>

                            <button @click="open = true;
                                            action = '{{ route('hotels.rooms.destroy', [$hotel->id, $room->id]) }}'"
                                    class="px-3 py-1.5
                                           bg-red-600 hover:bg-red-700
                                           text-white text-sm rounded">
                                🗑️ Hapus
                            </button>

                        </div>
                    </div>
                @endforeach

                {{-- MODAL HAPUS (TIDAK DIUBAH) --}}
                <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">

                    <div class="absolute inset-0 bg-black/50" @click="open = false"></div>

                    <div class="bg-white rounded-xl shadow-lg
                                w-full max-w-md p-6 relative z-10">
                        <h3 class="text-lg font-bold mb-2">Hapus Kamar</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Apakah kamu yakin ingin menghapus kamar ini?
                            Tindakan ini tidak bisa dibatalkan.
                        </p>

                        <div class="flex justify-end gap-2">
                            <button @click="open = false"
                                    class="px-4 py-2 text-sm rounded
                                           bg-gray-200 hover:bg-gray-300">
                                Batal
                            </button>

                            <form :action="action" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 text-sm rounded
                                               bg-red-600 text-white hover:bg-red-700">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded">
                Belum ada kamar untuk hotel ini.
            </div>
        @endif

    </div>

</x-app-layout>
