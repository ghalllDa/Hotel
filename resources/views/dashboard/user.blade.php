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

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let map = L.map('map').setView([-6.200000, 106.816666], 13);
            let markers = [];

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // ambil lokasi user
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    map.setView([lat, lng], 14);

                    L.marker([lat, lng])
                        .addTo(map)
                        .bindPopup("Lokasi Anda")
                        .openPopup();

                    loadHotels(lat, lng);
                });
            }

            function loadHotels(lat, lng, keyword = '') {
                fetch(`/hotels-nearby?lat=${lat}&lng=${lng}&q=${keyword}`)
                    .then(res => res.json())
                    .then(data => {

                        // clear marker
                        markers.forEach(m => map.removeLayer(m));
                        markers = [];

                        // clear list
                        const list = document.getElementById('hotel-list');
                        list.innerHTML = '';

                        if (data.length === 0) {
                            list.innerHTML = `<p class="text-gray-500">Hotel tidak ditemukan</p>`;
                            return;
                        }

                        data.forEach(hotel => {

                            // marker
                            const marker = L.marker([hotel.latitude, hotel.longitude])
                                .addTo(map)
                                .bindPopup(`
                            <strong>${hotel.nama_hotel}</strong><br>
                            Mulai dari Rp ${hotel.harga}<br>
                            <a href="/hotels/${hotel.id}">Detail</a>
                        `);

                            markers.push(marker);

                            // card
                            list.innerHTML += `
                            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <!-- Gambar -->
                            <img rc="${hotel.image ?? '/img/no-image.png'}" 
                                alt="${hotel.name}"
                                class="w-full h-44 object-cover"
                                nerror="this.src='/img/no-image.png'">

                            <div class="p-4">
                            <!-- Nama hotel -->
                            <h3 class="text-lg font-bold text-gray-800">
                            ${hotel.nama_hotel}
                            </h3>

                            <!-- Lokasi -->
                            <p class="text-sm text-gray-500">
                            ${hotel.lokasi}
                            </p>

                            <!-- Fasilitas -->
                            <p class="text-sm text-blue-600 mt-1">
                            ${hotel.fasilitas}
                            </p>

                            <!-- Harga -->
                            <div class="mt-3">
                            <p class="text-sm text-gray-500">Mulai dari</p>
                            <p class="text-lg font-bold text-orange-600">
                                    Rp ${Number(hotel.harga).toLocaleString('id-ID')} / malam
                            </p>
                            </div>

                            <!-- Button -->
                            <a href="/hotels/${hotel.id}"
                            class="block mt-4 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg font-semibold transition">
                        Lihat Detail
                        </a>
                    </div>
                </div>
                `;

                        });
                    })
                    .catch(err => {
                        console.error('API ERROR:', err);
                    });
            }

            // tombol cari
            document.getElementById('btnCari').addEventListener('click', function () {
                const keyword = document.querySelector('input[type=text]').value;
                const center = map.getCenter();
                loadHotels(center.lat, center.lng, keyword);
            });

        });
    </script>

</x-app-layout>