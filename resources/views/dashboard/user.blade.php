<x-app-layout>
    <!-- DASHBOARD ROLE -->
    <div class="bg-blue-50 p-6">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-blue-700 mb-4">
                Penginapan Hotelku
            </h1>

            <!-- HERO SECTION -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-400 py-12">
                <div class="max-w-7xl mx-auto px-6 text-white">
                    <h1 class="text-3xl font-bold mb-2">
                        Booking Hotel & Penginapan Murah
                    </h1>
                    <p class="text-sm mb-6">
                        Temukan hotel terbaik dengan harga promo
                    </p>

                    <!-- SEARCH BOX -->
                    <div class="bg-white rounded-lg shadow-lg p-4 text-gray-700 grid grid-cols-1 md:grid-cols-5 gap-3">
                        <input type="text" placeholder="Kota / Hotel" class="border rounded px-3 py-2 col-span-2">
                        <input type="date" class="border rounded px-3 py-2">
                        <input type="date" class="border rounded px-3 py-2">
                        <input type="number" placeholder="Tamu" class="border rounded px-3 py-2">
                        <button id="btnCari" class="bg-orange-500 hover:bg-orange-600 text-white rounded px-4 py-2">
                            Cari
                        </button>
                    </div>
                </div>
            </div>

            <!-- MAP SECTION -->
            <div class="max-w-7xl mx-auto px-6 mt-6">
                <div id="map" class="w-full h-96 rounded-lg shadow"></div>
            </div>

            <!-- HOTEL LIST SECTION -->
            <div class="max-w-7xl mx-auto px-6 mt-10">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Hasil Pencarian Hotel
                </h2>
                <div id="hotel-list" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    {{-- hotel akan muncul via JS --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ TAMBAHAN: DATA HOTEL DARI CONTROLLER --}}
    <script>
        window.initialHotels = @json($hotels);
    </script>

    <!-- SCRIPT UTAMA -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            window.map = L.map('map').setView([-6.200000, 106.816666], 13);
            window.markers = [];

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(window.map);

            const list = document.getElementById('hotel-list');

            function renderHotels(data) {
                list.innerHTML = '';
                window.markers.forEach(m => window.map.removeLayer(m));
                window.markers = [];

                if (!data || data.length === 0) {
                    list.innerHTML = `<p class="text-gray-500">Hotel tidak ditemukan</p>`;
                    return;
                }

                data.forEach(hotel => {
                    if (hotel.latitude && hotel.longitude) {
                        const marker = L.marker([hotel.latitude, hotel.longitude])
                            .addTo(window.map)
                            .bindPopup(`<strong>${hotel.nama_hotel}</strong><br>${hotel.lokasi}`);
                        window.markers.push(marker);
                    }

                    list.innerHTML += `
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <img src="${hotel.images?.[0]?.path ? '/storage/' + hotel.images[0].path : '/img/no-image.png'}"
                                 class="w-full h-44 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold">${hotel.nama_hotel}</h3>
                                <p class="text-sm text-gray-500">${hotel.lokasi}</p>
                                <p class="text-orange-600 font-bold mt-2">
                                    Rp ${Number(hotel.harga).toLocaleString('id-ID')} / malam
                                </p>
                                <a href="/hotels/${hotel.id}"
                                   class="block mt-3 bg-blue-600 text-white text-center py-2 rounded">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>`;
                });
            }

            // ✅ TAMPILKAN HOTEL LANGSUNG DARI CONTROLLER
            renderHotels(window.initialHotels);

            // API tetap dipakai saat search
            document.getElementById('btnCari').addEventListener('click', function () {
                const keyword = document.querySelector('input[type=text]').value;
                fetch(`/hotels-nearby?q=${keyword}`)
                    .then(res => res.json())
                    .then(data => renderHotels(data))
                    .catch(() => renderHotels(window.initialHotels));
            });
        });
    </script>
</x-app-layout>
