<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold">
                {{ $hotel->nama_hotel }}
            </h1>
            <p class="text-gray-500">
                {{ $hotel->lokasi }}
            </p>
        </div>

        <!-- INFO HOTEL -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- GAMBAR -->
            <div>
                @if($hotel->gambar)
                    <img src="{{ asset('storage/'.$hotel->gambar) }}"
                         class="w-full h-60 object-cover rounded-lg shadow">
                @else
                    <div class="w-full h-60 bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg">
                        Tidak ada gambar
                    </div>
                @endif
            </div>

            <!-- DETAIL -->
            <div class="md:col-span-2 space-y-3">
                <p>
                    <strong>Fasilitas:</strong><br>
                    {{ $hotel->fasilitas }}
                </p>

                <p>
                    <strong>Harga mulai:</strong>
                    Rp {{ number_format($hotel->harga, 0, ',', '.') }} / malam
                </p>

                <div class="mt-4">
                    <a href="{{ route('hotels.rooms.create', $hotel->id) }}"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        ➕ Tambah Kamar
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>

