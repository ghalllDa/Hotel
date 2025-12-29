<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($hotels as $hotel)
            <a href="{{ route('admin.hotels.show', $hotel->id) }}"
                class="block bg-white rounded-lg shadow hover:shadow-xl transition overflow-hidden">

                {{-- GAMBAR HOTEL --}}
                @php
                    $gambar = $hotel->images->first();
                @endphp

                @if($gambar)
                    <img src="{{ asset('storage/' . $gambar->path) }}" class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                        Tidak ada gambar
                    </div>
                @endif

                {{-- INFO HOTEL --}}
                <div class="p-4">
                    <h2 class="font-bold text-lg">
                        {{ $hotel->nama_hotel }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        {{ $hotel->lokasi }}
                    </p>

                    <p class="text-sm mt-1">
                        Fasilitas: {{ $hotel->fasilitas }}
                    </p>
                </div>

            </a>
        @endforeach

    </div>
</x-app-layout>