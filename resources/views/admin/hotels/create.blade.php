<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto px-6 py-10">

            {{-- HEADER --}}
            <div class="mb-8">
                <a href="{{ route('hotels.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4">
                    ← Kembali ke Daftar Hotel
                </a>

                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100
                                flex items-center justify-center text-blue-600 text-xl">
                        🏨
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Hotel
                        </h1>
                        <p class="text-sm text-gray-500">
                            Lengkapi informasi hotel dengan benar
                        </p>
                    </div>
                </div>

                <div class="mt-6 h-px bg-gradient-to-r
                            from-transparent via-gray-300 to-transparent"></div>
            </div>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('hotels.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="bg-white rounded-2xl shadow-xl p-8 space-y-8">
                @csrf

                {{-- INFORMASI UTAMA --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Informasi Utama
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Hotel
                            </label>
                            <input type="text" name="nama_hotel"
                                   class="w-full rounded-xl border-gray-300
                                          focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Alamat / Lokasi
                            </label>
                            <input type="text" name="lokasi" id="lokasi"
                                   class="w-full rounded-xl border-gray-300
                                          focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: Jl Asia Afrika Bandung"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">
                                Ketik lokasi → Enter → geser marker jika perlu
                            </p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Deskripsi Hotel
                        </label>
                        <textarea name="deskripsi" rows="4"
                                  class="w-full rounded-xl border-gray-300
                                         focus:ring-blue-500 focus:border-blue-500"
                                  required>{{ old('deskripsi') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Contoh: Hotel nyaman di pusat kota dengan fasilitas lengkap
                        </p>
                    </div>
                </div>

                {{-- LOKASI --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Lokasi Hotel
                    </h2>

                    <input type="hidden" name="latitude" id="latitude" value="-6.200000">
                    <input type="hidden" name="longitude" id="longitude" value="106.816666">

                    <div class="rounded-xl overflow-hidden border">
                        <div id="map" class="h-72"></div>
                    </div>
                </div>

                {{-- DETAIL --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Detail Tambahan
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Harga per Malam
                            </label>
                            <input type="number" name="harga"
                                   class="w-full rounded-xl border-gray-300
                                          focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="350000"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Bintang Hotel
                            </label>
                            <select name="stars"
                                    class="w-full rounded-xl border-gray-300
                                           focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Fasilitas
                            </label>
                            <input type="text" name="fasilitas"
                                   class="w-full rounded-xl border-gray-300
                                          focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="AC, WiFi, Sarapan"
                                   required>
                        </div>
                    </div>
                </div>

                {{-- GAMBAR --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Gambar Hotel
                    </h2>

                    <input type="file" name="images[]" id="gambar" multiple accept="image/*"
                           class="block w-full text-sm text-gray-600
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-xl file:border-0
                                  file:bg-blue-100 file:text-blue-700
                                  hover:file:bg-blue-200 transition">

                    <p class="text-xs text-gray-500 mt-2">
                        Bisa upload lebih dari satu gambar
                    </p>

                    <div id="preview" class="mt-4 flex gap-3 flex-wrap"></div>
                </div>

                {{-- ACTION --}}
                <div class="flex justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('hotels.index') }}"
                       class="px-6 py-2.5 rounded-xl bg-gray-100 text-gray-700
                              font-semibold hover:bg-gray-200 transition">
                        Batal
                    </a>

                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-blue-600 text-white
                                   font-semibold hover:bg-blue-700 transition shadow">
                        Simpan Hotel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- LEAFLET & SCRIPT ASLI (TIDAK DIUBAH) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const defaultLat = -6.200000;
        const defaultLng = 106.816666;

        const map = L.map('map').setView([defaultLat, defaultLng], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        latitude.value = defaultLat;
        longitude.value = defaultLng;

        marker.on('dragend', () => {
            const pos = marker.getLatLng();
            latitude.value = pos.lat;
            longitude.value = pos.lng;
        });

        map.on('click', e => {
            marker.setLatLng(e.latlng);
            latitude.value = e.latlng.lat;
            longitude.value = e.latlng.lng;
        });

        document.getElementById('lokasi').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.value)}&countrycodes=id&limit=1`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.length) return alert('Lokasi tidak ditemukan');
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        map.setView([lat, lon], 16);
                        marker.setLatLng([lat, lon]);
                        latitude.value = lat;
                        longitude.value = lon;
                    });
            }
        });

        document.getElementById('gambar').addEventListener('change', function (e) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';
            [...e.target.files].forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'w-32 h-24 object-cover rounded-xl border';
                preview.appendChild(img);
            });
        });

        document.querySelector('form').addEventListener('submit', function (e) {
            if (!latitude.value || !longitude.value) {
                e.preventDefault();
                alert('Silakan tentukan lokasi hotel di peta terlebih dahulu.');
            }
        });
    </script>
</x-app-layout>
