<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- TOMBOL KEMBALI -->
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full
          bg-white shadow-sm border border-gray-200
          text-sm font-semibold text-gray-700
          hover:bg-gray-50 hover:text-orange-600
          transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>

            Kembali ke Dashboard
        </a>

        <!-- NAMA HOTEL -->
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            {{ $hotel->nama_hotel }}
        </h1>

        <p class="text-gray-500 mb-4">
            {{ $hotel->lokasi }}
        </p>

        <!-- GALERI FOTO -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            @forelse ($hotel->images as $img)
                <img src="{{ asset('storage/' . $img->path) }}" class="rounded-lg object-cover h-56 w-full">
            @empty
                <img src="/img/no-image.png" class="rounded-lg object-cover h-56 w-full">
            @endforelse
        </div>

        <!-- CARD HARGA -->
        <div
            class="md:col-span-3 bg-white rounded-lg shadow p-6 mb-6 flex flex-col md:flex-row justify-between items-center">

            <div>
                <p class="text-gray-500 text-sm">Mulai dari</p>
                <p class="text-2xl font-bold text-orange-600">
                    Rp {{ number_format($hotel->harga, 0, ',', '.') }} / malam
                </p>
            </div>

            <a href="#kamar"
                class="mt-4 md:mt-0 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-bold transition">
                Pilih Kamar
            </a>
        </div>

        <!-- GRID KONTEN -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-3 space-y-6">

                <!-- DESKRIPSI -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-2">Deskripsi Hotel</h2>
                    <p class="text-gray-600">{{ $hotel->deskripsi }}</p>
                </div>

                <!-- FASILITAS -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-2">Fasilitas</h2>
                    <ul class="grid grid-cols-2 gap-2 text-gray-600">
                        @foreach (explode(',', $hotel->fasilitas) as $f)
                            <li>✔ {{ $f }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- KAMAR TERSEDIA -->
                <div id="kamar" class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Kamar Tersedia</h2>

                    @if ($hotel->rooms->where('status', 'tersedia')->count() === 0)
                        <p class="text-gray-500">Tidak ada kamar tersedia</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($hotel->rooms as $room)
                                @if ($room->status === 'tersedia')
                                    @php
                                        $promo = $room->promos->first();
                                        $hargaDiskon = $promo
                                            ? $room->harga - ($room->harga * $promo->diskon / 100)
                                            : null;
                                    @endphp

                                    <div class="border rounded-lg p-4 flex flex-col md:flex-row gap-4 relative">

                                        {{-- BADGE PROMO --}}
                                        @if($promo)
                                            <span class="absolute top-3 right-3 bg-red-600 text-white
                                                         text-xs font-bold px-3 py-1 rounded-full">
                                                Promo {{ $promo->diskon }}%
                                            </span>
                                        @endif

                                        <!-- FOTO KAMAR -->
                                        <div class="w-full md:w-48 h-40 flex-shrink-0">
                                            @if ($room->foto)
                                                <img src="{{ asset('storage/' . $room->foto) }}"
                                                    class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <img src="/img/no-image.png"
                                                    class="w-full h-full object-cover rounded-lg">
                                            @endif
                                        </div>

                                        <!-- INFO + HARGA -->
                                        <div class="flex flex-col md:flex-row justify-between w-full gap-4">

                                            <!-- INFO -->
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-800">
                                                    {{ $room->nama_kamar }}
                                                </h3>

                                                <ul class="text-sm text-gray-600 list-disc list-inside">
                                                    @foreach ($room->fasilitas as $f)
                                                        <li>{{ $f }}</li>
                                                    @endforeach
                                                </ul>

                                                <p class="text-sm text-gray-500 mt-1">
                                                    Kapasitas: {{ $room->kapasitas }} orang
                                                </p>
                                            </div>

                                            <!-- HARGA + BUTTON -->
                                            <div class="text-right">
                                                @if($promo)
                                                    <p class="text-sm text-gray-400 line-through">
                                                        Rp {{ number_format($room->harga, 0, ',', '.') }}
                                                    </p>
                                                    <p class="text-orange-600 font-bold text-lg">
                                                        Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                                                    </p>
                                                @else
                                                    <p class="text-orange-600 font-bold text-lg">
                                                        Rp {{ number_format($room->harga, 0, ',', '.') }}
                                                    </p>
                                                @endif

                                                <p class="text-xs text-gray-500">/ malam</p>

                                                <a href="{{ route('booking.create', $room->id) }}"
                                                   class="mt-2 inline-block bg-blue-600 hover:bg-blue-700
                                                          text-white px-4 py-2 rounded-lg font-semibold">
                                                    Pilih Kamar
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- MAP -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Lokasi Hotel</h2>
                    <div id="map" class="w-full h-80 rounded"></div>
                </div>

            </div>
        </div>

        <!-- LEAFLET -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <script>
            const map = L.map('map').setView(
                [{{ $hotel->latitude }}, {{ $hotel->longitude }}], 15
            );

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            L.marker([{{ $hotel->latitude }}, {{ $hotel->longitude }}])
                .addTo(map)
                .bindPopup("{{ $hotel->nama_hotel }}")
                .openPopup();
        </script>
    </div>
</x-app-layout>
