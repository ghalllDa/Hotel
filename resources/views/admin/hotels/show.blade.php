<x-app-layout>

    <div class="max-w-7xl mx-auto px-6 py-6">

        {{-- BUTTON KEMBALI --}}
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 mb-6
                  px-4 py-2
                  bg-blue-600 text-white
                  text-sm font-semibold
                  rounded-lg
                  shadow
                  hover:bg-blue-700
                  transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-4 w-4"
                 fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 19l-7-7 7-7" />
            </svg>

            Kembali ke Dashboard
        </a>

        {{-- BANNER HOTEL --}}
        <div class="relative h-[320px] rounded-xl overflow-hidden mb-6"
             style="background-image: url('{{ asset('storage/'.$hotel->gambar) }}');
                    background-size: cover;
                    background-position: center;">

            <div class="absolute inset-0 bg-black/40"></div>

            <div class="absolute bottom-6 left-6 text-white">
                <h2 class="text-2xl font-bold">{{ $hotel->nama_hotel }}</h2>
                <p class="mb-4">{{ $hotel->lokasi }}</p>

                <a href="{{ route('hotels.rooms.create', $hotel->id) }}"
                   class="inline-flex items-center gap-2
                          bg-blue-600 hover:bg-blue-700
                          px-4 py-2 rounded-lg
                          text-sm font-semibold shadow">
                    ➕ Tambah Kamar
                </a>
            </div>
        </div>

        {{-- DAFTAR KAMAR --}}
        <h3 class="text-lg font-bold mb-4">Daftar Kamar</h3>

        @if($hotel->rooms->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($hotel->rooms as $room)
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="font-semibold text-lg">{{ $room->nama_kamar }}</h4>

                        <p class="text-sm mt-1">
                            <strong>Harga:</strong>
                            Rp {{ number_format($room->harga, 0, ',', '.') }}
                        </p>

                        <p class="text-sm mt-1">
                            <strong>Status:</strong>
                            <span class="px-2 py-1 rounded text-xs
                                {{ $room->status == 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </p>

                        <p class="text-sm mt-2">
                            <strong>Fasilitas:</strong><br>
                            {{ is_array($room->fasilitas) ? implode(', ', $room->fasilitas) : '-' }}
                        </p>

                         <a href="{{ route('hotels.rooms.edit', [$hotel->id, $room->id]) }}"
   class="inline-block mt-3
          px-3 py-1.5
          bg-yellow-500 hover:bg-yellow-600
          text-white text-sm rounded">
    ✏️ Edit Kamar
</a>


                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded">
                Belum ada kamar untuk hotel ini.
            </div>
        @endif

    </div>

</x-app-layout>
