<x-app-layout>
    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto px-6 mt-8 mb-6">
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
            🏨 Hotel Terdaftar
        </h1>
        <p class="text-gray-500 mt-1">
            Kelola dan pantau seluruh hotel yang tersedia
        </p>
    </div>

    {{-- GRID HOTEL --}}
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 pb-12">

        @foreach($hotels as $hotel)
            <a href="{{ route('admin.hotels.show', $hotel->id) }}"
               class="group relative bg-white rounded-2xl overflow-hidden
                      shadow-md hover:shadow-2xl transition duration-300">

                {{-- GAMBAR --}}
                @php
                    $gambar  = $hotel->images->first();
                    $bintang = (int) ($hotel->stars ?? 0); // ✅ FIX DI SINI
                @endphp

                <div class="relative h-52">
                    @if($gambar)
                        <img src="{{ asset('storage/' . $gambar->path) }}"
                             class="w-full h-full object-cover transform
                                    group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300
                                    flex items-center justify-center text-gray-600">
                            <span class="text-sm italic">No Image</span>
                        </div>
                    @endif

                    {{-- OVERLAY GRADIENT --}}
                    <div class="absolute inset-0 bg-gradient-to-t
                                from-black/60 via-black/20 to-transparent"></div>

                    {{-- BADGE BINTANG (SUDAH FIX) --}}
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur
                                px-3 py-1 rounded-full shadow flex items-center gap-1">

                        @if ($bintang > 0)
                            @for ($i = 1; $i <= $bintang; $i++)
                                <span class="text-yellow-400 text-sm">★</span>
                            @endfor
                        @else
                            <span class="text-xs text-gray-500 italic">
                                Belum diberi bintang
                            </span>
                        @endif

                    </div>
                </div>

                {{-- KONTEN --}}
                <div class="p-5">
                    <h2 class="text-xl font-bold text-gray-800 mb-1 group-hover:text-orange-600 transition">
                        {{ $hotel->nama_hotel }}
                    </h2>

                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        📍 {{ $hotel->lokasi }}
                    </p>

                    {{-- FASILITAS --}}
                    <div class="flex flex-wrap gap-2 mt-4">
                        @foreach(explode(',', $hotel->fasilitas) as $fasilitas)
                            <span class="text-xs px-3 py-1 rounded-full
                                         bg-orange-50 text-orange-600 font-medium">
                                {{ trim($fasilitas) }}
                            </span>
                        @endforeach
                    </div>

                    {{-- FOOTER CARD --}}
                    <div class="flex justify-between items-center mt-6">
                        <span class="text-sm text-gray-400">
                        </span>

                        <span class="text-sm font-semibold text-orange-600
                                     group-hover:translate-x-1 transition">
                            Lihat Detail →
                        </span>
                    </div>
                </div>

            </a>
        @endforeach

    </div>
</x-app-layout>
