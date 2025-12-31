<x-app-layout>
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc, #eef2ff);
        }

        .hotel-card {
            transition: all .35s ease;
        }

        .hotel-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,.25);
        }

        .hotel-image img {
            transition: transform .6s ease;
        }

        .hotel-card:hover .hotel-image img {
            transform: scale(1.12);
        }

        .lux-badge {
            backdrop-filter: blur(6px);
        }
    </style>

    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto px-6 mt-10 mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight flex items-center gap-2">
            🏨 Hotel Terdaftar
        </h1>
        <p class="text-gray-500 mt-1">
            Kelola dan pantau seluruh hotel yang tersedia
        </p>
    </div>

    {{-- GRID HOTEL --}}
    <div class="max-w-7xl mx-auto px-6
                grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
                gap-8 pb-16">

        @foreach($hotels as $hotel)
            <a href="{{ route('admin.hotels.show', $hotel->id) }}"
               class="hotel-card group bg-white rounded-2xl overflow-hidden">

                @php
                    $gambar  = $hotel->images->first();
                    $bintang = (int) ($hotel->stars ?? 0);
                @endphp

                {{-- IMAGE --}}
                <div class="hotel-image relative h-52 overflow-hidden">

                    @if($gambar)
                        <img src="{{ asset('storage/' . $gambar->path) }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300
                                    flex items-center justify-center text-gray-500 italic text-sm">
                            No Image
                        </div>
                    @endif

                    {{-- OVERLAY --}}
                    <div class="absolute inset-0 bg-gradient-to-t
                                from-black/60 via-black/20 to-transparent"></div>

                    {{-- STAR BADGE --}}
                    <div class="absolute top-4 left-4 lux-badge
                                bg-white/90 px-3 py-1 rounded-full
                                shadow flex items-center gap-1">

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

                {{-- CONTENT --}}
                <div class="p-5">

                    <h2 class="text-lg font-bold text-gray-800
                               group-hover:text-orange-600 transition">
                        {{ $hotel->nama_hotel }}
                    </h2>

                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                        📍 {{ $hotel->lokasi }}
                    </p>

                    {{-- FASILITAS --}}
                    <div class="flex flex-wrap gap-2 mt-4">
                        @foreach(explode(',', $hotel->fasilitas) as $fasilitas)
                            <span class="text-xs px-3 py-1 rounded-full
                                         bg-orange-50 text-orange-600
                                         font-medium">
                                {{ trim($fasilitas) }}
                            </span>
                        @endforeach
                    </div>

                    {{-- FOOTER --}}
                    <div class="flex justify-end mt-6">
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
