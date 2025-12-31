<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">

        </a>

        {{-- Kembali ke Daftar Hotel --}}
        <a href="{{ route('hotels.index') }}" class="inline-flex items-center gap-2
              bg-blue-600 hover:bg-blue-700
              text-white font-semibold text-sm
              px-5 py-2.5 rounded-lg
              shadow transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>

            Kembali ke Daftar Hotel

        </a>


        <h1 class="text-2xl font-bold mb-6">Edit Hotel</h1>

        {{-- ERROR VALIDATION --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('hotels.update', $hotel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama Hotel --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Hotel</label>
                <input type="text" name="nama_hotel" value="{{ old('nama_hotel', $hotel->nama_hotel) }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Lokasi --}}
            <div class="mb-2">
                <label class="block font-medium mb-1">Alamat / Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $hotel->lokasi) }}"
                    class="w-full border rounded px-3 py-2" required>
                <p class="text-sm text-gray-500 mt-1">
                    Ketik lokasi → Enter → jika kurang tepat, geser marker manual
                </p>
            </div>

            {{-- Deskripsi Hotel --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi Hotel</label>

                <textarea name="deskripsi" rows="5" class="w-full border rounded px-3 py-2"
                    placeholder="Ceritakan tentang hotel ini..."
                    required>{{ old('deskripsi', $hotel->deskripsi) }}</textarea>
            </div>

            {{-- Hidden koordinat --}}
            <input type="hidden" name="latitude" id="latitude" value="{{ $hotel->latitude }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ $hotel->longitude }}">

            {{-- MAP --}}
            <div class="mb-6">
                <div id="map" class="w-full h-80 border rounded"></div>
            </div>

            {{-- Harga --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Harga (per malam)</label>
                <input type="number" name="harga" value="{{ old('harga', $hotel->harga) }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>
            {{-- ⭐ Bintang Hotel --}}
<div class="mb-4">
    <label class="block font-medium mb-1">Bintang Hotel</label>
    <select name="stars" class="w-full border rounded px-3 py-2" required>
        @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" {{ $hotel->stars == $i ? 'selected' : '' }}>
                {{ $i }} ⭐
            </option>
        @endfor
    </select>
</div>

            {{-- Fasilitas --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Fasilitas</label>
                <textarea name="fasilitas" rows="4" class="w-full border rounded px-3 py-2"
                    required>{{ old('fasilitas', $hotel->fasilitas) }}</textarea>
            </div>

            {{-- GALERI GAMBAR HOTEL --}}
            <div class="mb-6">
                <label class="block font-medium mb-2">Gambar Hotel Saat Ini</label>

                @if ($hotel->images->count())
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($hotel->images as $img)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-28 object-cover rounded border">
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">Belum ada gambar</p>
                @endif
            </div>


            {{-- TAMBAH GAMBAR BARU --}}
            <div class="mb-6">
                <label class="block font-medium mb-1">Tambah Gambar Baru</label>

                <input type="file" name="images[]" id="gambar" accept="image/*" multiple
                    class="w-full border rounded px-3 py-2">

                <p class="text-sm text-gray-500 mt-1">
                    Bisa pilih lebih dari satu gambar
                </p>

                <div id="preview" class="mt-3 flex gap-3 flex-wrap"></div>
            </div>


            {{-- BUTTON --}}
            <div class="flex gap-2">
                <button class="bg-blue-600 text-white px-5 py-2 rounded">
                    Update
                </button>

                <a href="{{ route('hotels.index') }}" class="bg-gray-300 px-5 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- LEAFLET --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const lat = {{ $hotel->latitude }};
        const lng = {{ $hotel->longitude }};

        const map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);

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

        document.getElementById('gambar')?.addEventListener('change', function (e) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';

            [...e.target.files].forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'w-32 h-24 object-cover rounded border';

                preview.appendChild(img);
            });
        });

        // SEARCH LOKASI
        document.getElementById('lokasi').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();

                fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.value)}&countrycodes=id&limit=1`
                )
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
    </script>
</x-app-layout> 