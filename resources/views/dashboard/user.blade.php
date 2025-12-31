<x-app-layout>
    <div class="bg-blue-50 p-6">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-blue-700 mb-4">
                Penginapan Hotelku
            </h1>

            <!-- HERO -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-400 py-12">
                <div class="max-w-7xl mx-auto px-6 text-white">
                    <h1 class="text-3xl font-bold mb-2">
                        Booking Hotel & Penginapan Murah
                    </h1>
                    <p class="text-sm mb-6">
                        Temukan hotel terbaik dengan harga promo
                    </p>

                    <div class="bg-white rounded-lg shadow-lg p-4 text-gray-700 grid grid-cols-1 md:grid-cols-5 gap-3">
                        <input type="text" id="keyword" placeholder="Kota / Hotel"
                               class="border rounded px-3 py-2 col-span-2">
                        <input type="date" class="border rounded px-3 py-2">
                        <input type="date" class="border rounded px-3 py-2">
                        <input type="number" placeholder="Tamu" class="border rounded px-3 py-2">
                        <button id="btnCari"
                                class="bg-orange-500 hover:bg-orange-600 text-white rounded px-4 py-2">
                            Cari
                        </button>
                    </div>
                </div>
            </div>

            <!-- MAP -->
            <div class="max-w-7xl mx-auto px-6 mt-6">
                <div id="map" class="w-full h-96 rounded-lg shadow"></div>
            </div>

            <!-- LIST -->
            <div class="max-w-7xl mx-auto px-6 mt-10">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Hasil Pencarian Hotel
                </h2>
                <div id="hotel-list" class="grid grid-cols-1 md:grid-cols-4 gap-6"></div>
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
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <img src="${hotel.images?.[0]?.path ? '/storage/' + hotel.images[0].path : '/img/no-image.png'}"
                                 class="w-full h-44 object-cover">

                            <div class="p-4">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-bold">${hotel.nama_hotel}</h3>
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

                                <p class="text-orange-600 font-bold mt-2">
                                    Rp ${Number(hotel.harga).toLocaleString('id-ID')} / malam
                                </p>

                                <a href="/hotels/${hotel.id}"
                                   class="block mt-3 bg-blue-600 text-white text-center py-2 rounded">
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
