<x-app-layout>

    <!-- ================= MAIN CONTENT ================= -->
    <div class="min-h-screen bg-gradient-to-br from-blue-100 via-slate-100 to-blue-200 py-12">

        <div class="max-w-7xl mx-auto
                    bg-white/80 backdrop-blur-xl
                    border border-white/40
                    rounded-3xl shadow-2xl
                    p-8">

            <!-- TOMBOL KEMBALI
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 mb-8 px-5 py-2.5 rounded-full
                      bg-white shadow-sm border border-gray-200
                      text-sm font-semibold text-gray-700
                      hover:bg-gray-50 hover:text-orange-600 transition">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>

                Kembali ke Dashboard
            </a> -->

            <!-- HEADER HOTEL -->
            <div class="mb-4">
    <div class="flex items-center gap-3">
        <h1 class="text-3xl font-bold text-gray-800">
            {{ $hotel->nama_hotel }}
        </h1>

        {{-- BINTANG HOTEL --}}
        @if ($hotel->stars)
            <div class="flex text-xl">
                @for ($i = 1; $i <= $hotel->stars; $i++)
                    <span class="text-yellow-400">★</span>
                @endfor
            </div>
        @endif
    </div>

    {{-- LOKASI --}}
    <p class="text-gray-500 mt-1">
        {{ $hotel->lokasi }}
    </p>
</div>


            <!-- GALERI FOTO -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                @forelse ($hotel->images as $img)
                    <img src="{{ asset('storage/' . $img->path) }}"
                         class="rounded-2xl object-cover h-64 w-full shadow">
                @empty
                    <img src="/img/no-image.png"
                         class="rounded-2xl object-cover h-64 w-full shadow">
                @endforelse
            </div>

            <!-- CARD HARGA -->
            <div class="bg-white/90 backdrop-blur
                        rounded-2xl shadow-lg
                        p-6 mb-10
                        flex flex-col md:flex-row
                        justify-between items-center">

                <div>
                    <p class="text-gray-500 text-sm">Mulai dari</p>
                    <p class="text-3xl font-extrabold text-orange-600">
                        Rp {{ number_format($hotel->harga, 0, ',', '.') }} / malam
                    </p>
                </div>

                <a href="#kamar"
                   class="mt-4 md:mt-0
                          bg-orange-500 hover:bg-orange-600
                          text-white px-8 py-3
                          rounded-xl font-bold shadow transition">
                    Pilih Kamar
                </a>
            </div>

            <!-- GRID KONTEN -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-3 space-y-8">

                    <!-- DESKRIPSI -->
                    <div class="bg-white/90 backdrop-blur rounded-2xl shadow p-6">
                        <h2 class="text-2xl font-bold mb-3">Deskripsi Hotel</h2>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $hotel->deskripsi }}
                        </p>
                    </div>

                    <!-- REVIEW HOTEL -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Review Hotel</h2>

    @php
        $avgRating = round($hotel->reviews->avg('rating'), 1);
        $totalReview = $hotel->reviews->count();
    @endphp

    @if ($totalReview > 0)
        <!-- RINGKASAN RATING -->
        <div class="flex items-center gap-4 mb-6">
            <div class="text-4xl font-bold text-orange-500">
                {{ $avgRating }}
            </div>

            <div>
                <div class="flex text-xl">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}">
                            ★
                        </span>
                    @endfor
                </div>
                <p class="text-sm text-gray-500">
                    Dari {{ $totalReview }} review
                </p>
            </div>
        </div>

        <!-- LIST REVIEW -->
        <div class="space-y-4">
            @foreach ($hotel->reviews->take(3) as $review)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-center mb-1">
                        <p class="font-semibold text-gray-800">
                            {{ $review->user->name }}
                        </p>
                        <div class="text-yellow-400 text-sm">
                            @for ($i = 1; $i <= $review->rating; $i++)
                                ★
                            @endfor
                        </div>
                    </div>

                    @if ($review->comment)
                        <p class="text-gray-600 text-sm">
                            {{ $review->comment }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($totalReview > 3)
            <p class="mt-4 text-sm text-gray-500">
                Menampilkan 3 review terbaru
            </p>
        @endif
    @else
        <p class="text-gray-500">
            Belum ada review untuk hotel ini.
        </p>
    @endif
</div>


                    <!-- FASILITAS -->
                    <div class="bg-white/90 backdrop-blur rounded-2xl shadow p-6">
                        <h2 class="text-2xl font-bold mb-4">Fasilitas</h2>
                        <ul class="grid grid-cols-2 md:grid-cols-3 gap-2 text-gray-600">
                            @foreach (explode(',', $hotel->fasilitas) as $f)
                                <li class="flex items-center gap-2">
                                    <span class="text-green-600">✔</span> {{ $f }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- KAMAR -->
                    <div id="kamar" class="bg-white/90 backdrop-blur rounded-2xl shadow p-6">
                        <h2 class="text-2xl font-bold mb-6">Kamar Tersedia</h2>

                        @if ($hotel->rooms->where('status', 'tersedia')->count() === 0)
                            <p class="text-gray-500">Tidak ada kamar tersedia</p>
                        @else
                            <div class="space-y-6">
                                @foreach ($hotel->rooms as $room)
                                    @if ($room->status === 'tersedia')
                                        @php
                                            $promo = $room->promos->first();
                                            $hargaDiskon = $promo
                                                ? $room->harga - ($room->harga * $promo->diskon / 100)
                                                : null;
                                        @endphp

                                        <div class="relative border rounded-2xl p-5
                                                    flex flex-col md:flex-row gap-6
                                                    hover:shadow-lg transition">

                                            @if($promo)
                                                <span class="absolute top-4 right-4
                                                             bg-red-600 text-white
                                                             text-xs font-bold
                                                             px-4 py-1 rounded-full">
                                                    Promo {{ $promo->diskon }}%
                                                </span>
                                            @endif

                                            <!-- FOTO KAMAR -->
                                            <div class="w-full md:w-48 h-40 flex-shrink-0">
                                                @if($room->gambar)
                                                    <img src="{{ asset('storage/' . $room->gambar) }}"
                                                        class="w-full h-40 object-cover rounded-lg mb-3">
                                                @endif          
                                            </div>


                                            <!-- INFO -->
                                            <div class="flex flex-col md:flex-row justify-between w-full gap-4">

                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-800">
                                                        {{ $room->nama_kamar }}
                                                    </h3>

                                                    <ul class="text-sm text-gray-600 list-disc list-inside">
                                                        @foreach ($room->fasilitas as $f)
                                                            <li>{{ $f }}</li>
                                                        @endforeach
                                                    </ul>

                                                    <p class="text-sm text-gray-500 mt-1">
                                                        Kapasitas: {{ $room->capacity ?? '-' }} orang
                                                    </p>
                                                </div>

                                                <div class="text-right">
                                                    @if($promo)
                                                        <p class="text-sm text-gray-400 line-through">
                                                            Rp {{ number_format($room->harga, 0, ',', '.') }}
                                                        </p>
                                                        <p class="text-orange-600 font-bold text-xl">
                                                            Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                                                        </p>
                                                    @else
                                                        <p class="text-orange-600 font-bold text-xl">
                                                            Rp {{ number_format($room->harga, 0, ',', '.') }}
                                                        </p>
                                                    @endif

                                                    <p class="text-xs text-gray-500 mb-2">/ malam</p>

                                                    <a href="{{ route('booking.form', $room->id) }}"
                                                       class="inline-block bg-blue-600 hover:bg-blue-700
                                                              text-white px-5 py-2 rounded-xl font-semibold">
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
                    <div class="bg-white/90 backdrop-blur rounded-2xl shadow p-6">
                        <h2 class="text-2xl font-bold mb-4">Lokasi Hotel</h2>
                        <div id="map" class="w-full h-96 rounded-2xl"></div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- ================= SUBSCRIBE ================= -->
    <section class="bg-white py-12">
        <div class="max-w-5xl mx-auto bg-blue-500 rounded-2xl px-8 py-10 text-white">
            <h2 class="text-2xl font-bold mb-2">
                Suscríbete y entérate de nuestras ofertas
            </h2>
            <p class="text-blue-100">
                Recibirás las mejores promociones y descuentos a tu email.
            </p>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-white border-t py-12">
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-sm text-gray-600">

            <div>
                <h4 class="font-bold mb-2">Compañía</h4>
                <p>Mi cuenta</p>
            </div>

            <div>
                <h4 class="font-bold mb-2">Políticas</h4>
                <p>Términos y condiciones</p>
                <p>Política de privacidad</p>
            </div>

            <div>
                <h4 class="font-bold mb-2">Ayuda</h4>
                <p>Atención al cliente</p>
                <p>Preguntas frecuentes</p>
            </div>

            <div>
                <h4 class="font-bold mb-2">Contáctanos</h4>
                <p>+511 616 9080</p>
                <p class="text-pink-600 font-semibold">Libro de Reclamaciones</p>
            </div>

        </div>
    </footer>

    <!-- LEAFLET (TIDAK DIUBAH) -->
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

</x-app-layout>
