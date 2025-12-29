<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">
        
      </a>

    {{-- Kembali ke Daftar Hotel --}}
    <a href="{{ route('hotels.index') }}"
       class="inline-flex items-center gap-2
              bg-blue-600 hover:bg-blue-700
              text-white font-semibold text-sm
              px-5 py-2.5 rounded-lg
              shadow transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5"
             fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 19l-7-7 7-7"/>
        </svg>

        Kembali ke Daftar Hotel
        
    </a>




        <h1 class="text-2xl font-bold mb-6">Tambah Hotel</h1>

        {{-- ✅ TAMBAHAN: TAMPILKAN ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('hotels.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            {{-- Nama Hotel --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Hotel</label>
                <input type="text"
                       name="nama_hotel"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            {{-- Lokasi --}}
            <div class="mb-2">
                <label class="block font-medium mb-1">Alamat / Lokasi</label>
                <input type="text"
                       name="lokasi"
                       id="lokasi"
                       placeholder="Contoh: Jl Asia Afrika Bandung"
                       class="w-full border rounded px-3 py-2"
                       required>
                <p class="text-sm text-gray-500 mt-1">
                    Ketik lokasi → Enter → jika kurang tepat, geser marker manual
                </p>
            </div>

            {{-- ✅ TAMBAHAN: DEFAULT VALUE (ANTI VALIDASI GAGAL) --}}
            <input type="hidden" name="latitude" id="latitude" value="-6.200000">
            <input type="hidden" name="longitude" id="longitude" value="106.816666">

            {{-- MAP --}}
            <div class="mb-6">
                <div id="map" class="w-full h-80 border rounded"></div>
            </div>

            {{-- Harga --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Harga (per malam)</label>
                <input type="number"
                       name="harga"
                       placeholder="Contoh: 350000"
                       class="w-full border rounded px-3 py-2"
                       required>
                <p class="text-sm text-gray-500 mt-1">
                    Masukkan harga dalam rupiah penuh (contoh: 350000)
                </p>
            </div>

            {{-- Fasilitas --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Fasilitas</label>
                <textarea name="fasilitas"
                          rows="4"
                          class="w-full border rounded px-3 py-2"
                          required></textarea>
            </div>

            {{-- Gambar --}}
            <div class="mb-6">
                <label class="block font-medium mb-1">Gambar Hotel</label>

                <input type="file"
                       name="gambar"
                       id="gambar"
                       accept="image/*"
                       class="w-full border rounded px-3 py-2">

                <img id="preview"
                     class="mt-3 w-48 h-32 object-cover rounded border hidden">
            </div>

            <button class="bg-blue-600 text-white px-5 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>

    {{-- LEAFLET --}}
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const defaultLat = -6.200000;
        const defaultLng = 106.816666;

        const map = L.map('map').setView([defaultLat, defaultLng], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

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

                fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.value)}&countrycodes=id&limit=1`
                )
                .then(res => res.json())
                .then(data => {
                    if (!data.length) {
                        alert('Lokasi tidak ditemukan');
                        return;
                    }

                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);

                    map.setView([lat, lon], 16);
                    marker.setLatLng([lat, lon]);

                    latitude.value = lat;
                    longitude.value = lon;
                });
            }
        });
    </script>

    {{-- PREVIEW GAMBAR --}}
    <script>
        document.getElementById('gambar').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar');
                this.value = '';
                return;
            }

            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        });

        {{-- ✅ TAMBAHAN: CEGAH SUBMIT JIKA KOORDINAT KOSONG --}}
        document.querySelector('form').addEventListener('submit', function (e) {
            if (!latitude.value || !longitude.value) {
                e.preventDefault();
                alert('Silakan tentukan lokasi hotel di peta terlebih dahulu.');
            }
        });
    </script>
</x-app-layout>
