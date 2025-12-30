<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8">

        <!-- BUTTON KEMBALI -->
        <a href="{{ route('admin.hotels.show', $hotel->id) }}"
           class="inline-flex items-center gap-2 mb-6 px-4 py-2
                  bg-blue-600 text-white text-sm font-semibold
                  rounded-lg shadow hover:bg-blue-700 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-4 w-4"
                 fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 19l-7-7 7-7" />
            </svg>

            Kembali ke Detail Hotel
        </a>

        <!-- CARD FORM -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">
                Edit Kamar — {{ $hotel->nama_hotel }}
            </h2>

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
                           class="w-full border rounded px-3 py-2"
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
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                {{-- KAPASITAS ORANG --}}
<div class="mb-4">
    <label class="block text-sm font-medium mb-1">
        Kapasitas Orang
    </label>
    <input type="number"
           name="capacity"
           value="{{ old('capacity', $room->capacity) }}"
           class="w-full border rounded px-3 py-2"
           min="1"
           required>
</div>


                <!-- STATUS -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">
                        Status
                    </label>
                    <select name="status"
                            class="w-full border rounded px-3 py-2">
                        <option value="tersedia"
                            {{ $room->status === 'tersedia' ? 'selected' : '' }}>
                            Tersedia
                        </option>
                        <option value="Penuh"
                            {{ $room->status === 'penuh' ? 'selected' : '' }}>
                            Penuh
                        </option>
                    </select>
                </div>

                <!-- FASILITAS -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">
                        Fasilitas (pisahkan dengan koma)
                    </label>
                    <input type="text"
                           name="fasilitas"
                           value="{{ is_array($room->fasilitas) ? implode(', ', $room->fasilitas) : '' }}"
                           class="w-full border rounded px-3 py-2"
                           placeholder="AC, TV, WiFi">
                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700
                               text-white px-5 py-2 rounded-lg font-semibold">
                    💾 Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
