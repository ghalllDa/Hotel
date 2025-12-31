<x-app-layout>

    <style>
        body {
            background:
                radial-gradient(circle at top left, rgba(59,130,246,0.18), transparent 45%),
                radial-gradient(circle at bottom right, rgba(37,99,235,0.15), transparent 45%),
                linear-gradient(135deg, #eef2ff, #f8fafc);
        }

        .lux-wrapper {
            display: flex;
            justify-content: center;
            padding-top: 4rem;
            padding-bottom: 4rem;
        }

        .lux-card {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            border-radius: 18px;
            box-shadow:
                0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
        }

        .lux-header {
            background: linear-gradient(135deg, #1e40af, #2563eb);
            padding: 1.5rem;
            color: white;
        }

        .lux-header h2 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .lux-header small {
            opacity: 0.85;
        }

        .lux-body {
            padding: 1.75rem;
        }

        .lux-input {
            border-radius: 12px;
            transition: all 0.25s ease;
        }

        .lux-input:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.25);
        }

        .lux-button {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            transition: all 0.25s ease;
        }

        .lux-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 25px rgba(37,99,235,0.35);
        }

        .lux-back {
             background: linear-gradient(135deg, #e5e7eb, #f3f4f6);
                color: #374151;
                transition: all 0.25s ease;
        }

        .lux-back:hover {
            background: linear-gradient(135deg, #d1d5db, #e5e7eb);
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        }
        
    </style>

    <div class="lux-wrapper">

        <div class="lux-card">

            <!-- HEADER -->
            <div class="lux-header">
                <h2>Edit Kamar</h2>
                <small>{{ $hotel->nama_hotel }}</small>
            </div>

            <!-- BODY -->
            <div class="lux-body">

                <form method="POST"
                      action="{{ route('hotels.rooms.update', [$hotel->id, $room->id]) }}">
                    @csrf
                    @method('PUT')

                    <!-- NAMA KAMAR -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">
                            Nama Kamar
                        </label>
                        <input type="text"
                               name="nama_kamar"
                               value="{{ old('nama_kamar', $room->nama_kamar) }}"
                               class="lux-input w-full border px-3 py-2"
                               required>
                    </div>

                    <!-- HARGA -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">
                            Harga per Malam
                        </label>
                        <input type="number"
                               name="harga"
                               value="{{ old('harga', $room->harga) }}"
                               class="lux-input w-full border px-3 py-2"
                               required>
                    </div>

                    <!-- KAPASITAS -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">
                            Kapasitas Orang
                        </label>
                        <input type="number"
                               name="capacity"
                               value="{{ old('capacity', $room->capacity) }}"
                               class="lux-input w-full border px-3 py-2"
                               min="1"
                               required>
                    </div>

                    <!-- STATUS -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">
                            Status
                        </label>
                        <select name="status"
                                class="lux-input w-full border px-3 py-2">
                            <option value="tersedia"
                                {{ $room->status === 'tersedia' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="penuh"
                                {{ $room->status === 'penuh' ? 'selected' : '' }}>
                                Penuh
                            </option>
                        </select>
                    </div>

                    <!-- FASILITAS -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-1">
                            Fasilitas
                        </label>
                        <input type="text"
                               name="fasilitas"
                               value="{{ is_array($room->fasilitas) ? implode(', ', $room->fasilitas) : '' }}"
                               class="lux-input w-full border px-3 py-2"
                               placeholder="AC, TV, WiFi">
                    </div>

                    <!-- ACTION -->
                    <div class="flex justify-between">
                        <a href="{{ route('admin.hotels.show', $hotel->id) }}"
                           class="lux-back px-4 py-2 rounded-lg text-sm font-medium">
                            Kembali
                        </a>

                        <button type="submit"
                                class="lux-button text-white px-5 py-2 rounded-lg font-semibold">
                            💾 Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
