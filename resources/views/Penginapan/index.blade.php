<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-blue-100 via-slate-100 to-blue-200 py-10">
        <div class="max-w-7xl mx-auto bg-white/80 backdrop-blur-xl border border-white/40 rounded-3xl shadow-2xl p-8">

            <h1 class="text-3xl font-extrabold text-blue-700 mb-6">
                Penginapan Hotelku
            </h1>

            {{-- SEARCH --}}
            <div class="relative rounded-3xl overflow-hidden mb-10">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
                     class="absolute inset-0 w-full h-full object-cover">

                <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-blue-700/60"></div>

                <div class="relative z-10 px-8 py-16 text-white">
                    <h2 class="text-4xl font-bold mb-3">
                        Booking Hotel & Penginapan
                    </h2>

                    <div class="bg-white/90 rounded-2xl shadow-xl p-5 grid grid-cols-1 md:grid-cols-5 gap-3 text-gray-700">
                        <input type="text" id="keyword" placeholder="Kota / Hotel"
                               class="border rounded-xl px-3 py-2 col-span-2">

                        <input type="date" class="border rounded-xl px-3 py-2">
                        <input type="date" class="border rounded-xl px-3 py-2">
                        <input type="number" placeholder="Tamu" class="border rounded-xl px-3 py-2">

                        <button id="btnCari"
                                class="bg-orange-500 hover:bg-orange-600 text-white rounded-xl px-4 py-2 font-semibold">
                            Cari
                        </button>
                    </div>
                </div>
            </div>

            {{-- MAP --}}
            <div class="mb-10">
                <div id="map" class="w-full h-96 rounded-3xl shadow-lg"></div>
            </div>

            {{-- LIST --}}
            <h2 class="text-2xl font-bold mb-6">Hasil Pencarian Hotel</h2>
            <div id="hotel-list" class="grid grid-cols-1 md:grid-cols-4 gap-8"></div>

        </div>
    </div>

    {{-- DATA --}}
    <script>
        window.initialHotels = @json($hotels);
        window.bookmarkedHotelIds = @json($bookmarkedHotelIds ?? []);
    </script>

    {{-- LEAFLET --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    {{-- JS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        /* MAP */
        const map = L.map('map').setView([-6.2, 106.816666], 12);
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

        /* RENDER LIST */
        const list = document.getElementById('hotel-list');

        function renderHotels(data) {
            list.innerHTML = '';
            renderMarkers(data);

            if (!data.length) {
                list.innerHTML = `<p class="text-gray-500 col-span-4">Hotel tidak ditemukan.</p>`;
                return;
            }

            data.forEach(hotel => {
                const saved = window.bookmarkedHotelIds.includes(hotel.id);

                list.innerHTML += `
                    <div class="bg-white rounded-2xl shadow overflow-hidden">
                        <img src="${hotel.images?.[0]?.path ? '/storage/' + hotel.images[0].path : '/img/no-image.png'}"
                             class="w-full h-44 object-cover">

                        <div class="p-5">
                            <h3 class="font-bold text-lg">${hotel.nama_hotel}</h3>
                            <p class="text-sm text-gray-500">${hotel.lokasi}</p>

                            <p class="text-orange-600 font-bold mt-3">
                                Rp ${Number(hotel.harga).toLocaleString('id-ID')} / malam
                            </p>

                            <a href="/hotels/${hotel.id}"
                               class="block mt-4 bg-blue-600 text-white text-center py-2 rounded-xl font-semibold">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                `;
            });
        }

        /* LOAD AWAL */
        renderHotels(window.initialHotels);

        /* SEARCH (CARA LAMA) */
        document.getElementById('btnCari').addEventListener('click', function () {
            const keyword = document.getElementById('keyword').value.toLowerCase();

            const filtered = window.initialHotels.filter(hotel =>
                hotel.nama_hotel.toLowerCase().includes(keyword) ||
                hotel.lokasi.toLowerCase().includes(keyword)
            );

            renderHotels(filtered);
        });

    });
    </script>

</x-app-layout>
