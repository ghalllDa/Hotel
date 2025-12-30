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

    <!-- SCRIPT UTAMA -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // map global
            window.map = L.map('map').setView([-6.200000, 106.816666], 13);
            window.markers = [];

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(window.map);

            const inputNama = document.querySelector('input[type=text]');
            const inputCheckin = document.querySelectorAll('input[type=date]')[0];
            const inputCheckout = document.querySelectorAll('input[type=date]')[1];
            const inputGuests = document.querySelector('input[type=number]');
            const btnCari = document.getElementById('btnCari');

            function loadHotels(lat = null, lng = null, keyword = '', checkin = '', checkout = '', guests = '') {
                const params = new URLSearchParams();
                if (lat !== null && lng !== null) {
                    params.append('lat', lat);
                    params.append('lng', lng);
                }
                if (keyword) params.append('q', keyword);
                if (checkin) params.append('checkin', checkin);
                if (checkout) params.append('checkout', checkout);
                if (guests) params.append('guests', guests);

                fetch(`/hotels-nearby?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        // hapus marker lama
                        window.markers.forEach(m => window.map.removeLayer(m));
                        window.markers = [];

                        // hapus list lama
                        const list = document.getElementById('hotel-list');
                        list.innerHTML = '';

                        if (!data || data.length === 0) {
                            list.innerHTML = `<p class="text-gray-500">Hotel tidak ditemukan</p>`;
                            return;
                        }

                        data.forEach(hotel => {
                            // marker
                            const marker = L.marker([hotel.latitude, hotel.longitude])
                                .addTo(window.map)
                                .bindPopup(`<strong>${hotel.nama_hotel}</strong><br>
                                    ${hotel.lokasi}<br>
                                    Mulai dari Rp ${Number(hotel.harga).toLocaleString('id-ID')}<br>
                                    <a href="/hotels/${hotel.id}">Detail</a>`);
                            window.markers.push(marker);

                            // card hotel
                            list.innerHTML += `
                                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                    <img src="${hotel.image ?? '/img/no-image.png'}" alt="${hotel.nama_hotel}" class="w-full h-44 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold text-gray-800">${hotel.nama_hotel}</h3>
                                        <p class="text-sm text-gray-500">${hotel.lokasi}</p>
                                        <p class="text-sm text-blue-600 mt-1">${hotel.fasilitas}</p>
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-500">Mulai dari</p>
                                            <p class="text-lg font-bold text-orange-600">
                                                Rp ${Number(hotel.harga).toLocaleString('id-ID')} / malam
                                            </p>
                                        </div>
                                        <a href="/hotels/${hotel.id}" class="block mt-4 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg font-semibold transition">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>`;
                        });

                        // fokus map ke hotel pertama
                        if (data[0]) {
                            window.map.setView([data[0].latitude, data[0].longitude], 13);
                        }
                    })
                    .catch(err => console.error('API ERROR:', err));
            }

            // Load awal (jika geolocation tersedia)
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    window.map.setView([lat, lng], 13);
                    L.marker([lat, lng]).addTo(window.map).bindPopup("Lokasi Anda").openPopup();

                    loadHotels(lat, lng); // load awal
                }, () => {
                    loadHotels(); // fallback tanpa posisi
                });
            } else {
                loadHotels(); // load awal tanpa posisi
            }

            // tombol cari
            btnCari.addEventListener('click', function() {
                const keyword = inputNama.value;
                const checkin = inputCheckin.value;
                const checkout = inputCheckout.value;
                const guests = inputGuests.value;
                const center = window.map.getCenter();

                loadHotels(center.lat, center.lng, keyword, checkin, checkout, guests);
            });
        });
    </script>
</x-app-layout>
