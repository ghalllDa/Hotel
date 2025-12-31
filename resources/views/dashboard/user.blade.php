<x-app-layout>

    <!-- BACKGROUND -->
    <div class="min-h-screen bg-gradient-to-br from-blue-100 via-slate-100 to-blue-200 py-10">

        <!-- MAIN CARD -->
        <div class="max-w-7xl mx-auto
                    bg-white/80 backdrop-blur-xl
                    border border-white/40
                    rounded-3xl shadow-2xl
                    p-8">

            <h1 class="text-3xl font-extrabold text-blue-700 mb-6 tracking-wide">
                Penginapan Hotelku
            </h1>

            {{-- ========================= --}}
            {{-- 🎫 TOMBOL TIKET --}}
            {{-- ========================= --}}
            <div class="flex justify-end mb-6">
                <a href="{{ route('tickets.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5
                          bg-green-600 text-white text-sm font-semibold
                          rounded-xl shadow hover:bg-green-700 transition">
                    🎫 Tiket Saya
                </a>
            </div>

            <!-- HERO -->
            <div class="relative rounded-3xl overflow-hidden mb-10">

                <!-- HERO IMAGE -->
                <img
                    src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
                    class="absolute inset-0 w-full h-full object-cover"
                    alt="Hotel Hero"
                >

                <!-- OVERLAY -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-blue-700/60"></div>

                <!-- CONTENT -->
                <div class="relative z-10 px-8 py-16 text-white">
                    <h1 class="text-4xl font-bold mb-3">
                        Booking Hotel & Penginapan Murah
                    </h1>
                    <p class="text-blue-100 mb-8 max-w-xl">
                        Temukan hotel terbaik dengan harga promo & lokasi strategis
                    </p>

                    <!-- SEARCH CARD -->
                    <div class="bg-white/90 backdrop-blur
                                rounded-2xl shadow-xl
                                p-5 text-gray-700
                                grid grid-cols-1 md:grid-cols-5 gap-3">

                        <input type="text" id="keyword" placeholder="Kota / Hotel"
                               class="border rounded-xl px-3 py-2 col-span-2">

                        <input type="date"
                               class="border rounded-xl px-3 py-2">

                        <input type="date"
                               class="border rounded-xl px-3 py-2">

                        <input type="number" placeholder="Tamu"
                               class="border rounded-xl px-3 py-2">

                        <button id="btnCari"
                                class="bg-orange-500 hover:bg-orange-600
                                       text-white rounded-xl px-4 py-2 font-semibold">
                            Cari
                        </button>
                    </div>
                </div>
            </div>

            <!-- MAP -->
            <div class="mb-10">
                <div id="map"
                     class="w-full h-96 rounded-3xl shadow-lg border border-white/50"></div>
            </div>

            <!-- LIST -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Hasil Pencarian Hotel
                </h2>

                <div id="hotel-list"
                     class="grid grid-cols-1 md:grid-cols-4 gap-8"></div>
            </div>
        </div>
    </div>

    <script>
        window.initialHotels = @json($hotels);
        window.bookmarkedHotelIds = @json($bookmarkedHotelIds);
    </script>

    {{-- LEAFLET --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const map = L.map('map').setView([-6.2, 106.816666], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            let markers = [];

            function renderMarkers(hotels) {
                markers.forEach(m => map.removeLayer(m));
                markers = [];
                hotels.forEach(hotel => {
                    if (hotel.latitude && hotel.longitude) {
                        markers.push(
                            L.marker([hotel.latitude, hotel.longitude])
                                .addTo(map)
                                .bindPopup(`<strong>${hotel.nama_hotel}</strong><br>${hotel.lokasi}`)
                        );
                    }
                });
            }

            const list = document.getElementById('hotel-list');

            function renderHotels(data) {
                list.innerHTML = '';
                renderMarkers(data);

                data.forEach(hotel => {
                    const saved = window.bookmarkedHotelIds.includes(hotel.id);

                    list.innerHTML += `
                        <div class="bg-white/90 backdrop-blur
                                    rounded-2xl shadow-lg
                                    overflow-hidden
                                    hover:shadow-2xl transition">

                            <img src="${hotel.images?.[0]?.path ? '/storage/' + hotel.images[0].path : '/img/no-image.png'}"
                                 class="w-full h-44 object-cover">

                            <div class="p-5">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-bold text-lg">${hotel.nama_hotel}</h3>
                                        <p class="text-sm text-gray-500">${hotel.lokasi}</p>
                                    </div>

                                    <button class="bookmark-btn ${saved ? 'saved' : ''}"
                                            data-id="${hotel.id}">
                                        <svg width="18" height="18" viewBox="0 0 24 24">
                                            <path d="M6 2h12v20l-6-3-6 3V2z"
                                                  stroke="currentColor"
                                                  stroke-width="1.5"
                                                  fill="${saved ? 'currentColor' : 'none'}"/>
                                        </svg>
                                    </button>
                                </div>

                                <p class="text-orange-600 font-bold mt-3">
                                    Rp ${Number(hotel.harga).toLocaleString('id-ID')} / malam
                                </p>

                                <a href="/hotels/${hotel.id}"
                                   class="block mt-4 bg-blue-600 hover:bg-blue-700
                                          text-white text-center py-2 rounded-xl font-semibold">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    `;
                });
            }

            renderHotels(window.initialHotels);

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.bookmark-btn');
                if (!btn) return;

                const hotelId = btn.dataset.id;
                const isSaved = btn.classList.contains('saved');

                fetch(`/hotels/${hotelId}/bookmark`, {
                    method: isSaved ? 'DELETE' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                }).then(() => {
                    btn.classList.toggle('saved');
                    btn.querySelector('path').setAttribute(
                        'fill',
                        btn.classList.contains('saved') ? 'currentColor' : 'none'
                    );
                });
            });
        });
    </script>

    <style>
        .bookmark-btn {
            background: white;
            border-radius: 9999px;
            padding: 6px;
            border: 1px solid #e5e7eb;
        }
        .bookmark-btn.saved svg {
            color: #ef4444;
        }
    </style>

</x-app-layout>
