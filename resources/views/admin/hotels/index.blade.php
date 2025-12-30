<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow">

        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 mb-6 px-5 py-2.5
          bg-gradient-to-r from-blue-600 to-blue-500
          text-white text-sm font-semibold rounded-lg
          shadow-md hover:shadow-lg
          hover:from-blue-700 hover:to-blue-600
          transition duration-200">

            <!-- ICON -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>

            Kembali ke Dashboard
        </a>



        <h1 class="text-2xl font-bold mb-4">Daftar Hotel</h1>

        <a href="{{ route('hotels.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            Tambah Hotel
        </a>

        <table class="w-full table-auto border">
            <thead class="bg-blue-100">
                <tr>
                    <th class="border px-4 py-2">Nama Hotel</th>
                    <th class="border px-4 py-2">Bintang</th>
                    <th class="border px-4 py-2">Lokasi</th>
                    <th class="border px-4 py-2">Harga</th>
                    <th class="border px-4 py-2">Fasilitas</th>
                    <th class="border px-4 py-2">Gambar</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hotels as $hotel)
                    <tr>
                        <td class="border px-4 py-2">{{ $hotel->nama_hotel }}</td>
                        <td class="border px-4 py-2 text-yellow-500">
                            {{ str_repeat('⭐', $hotel->stars) }}</td>
                        <td class="border px-4 py-2">{{ $hotel->lokasi }}</td>

                        {{-- HARGA FIX --}}
                        <td class="border px-4 py-2">
                            Rp {{ number_format($hotel->harga, 0, ',', '.') }}
                        </td>

                        <td class="border px-4 py-2">{{ $hotel->fasilitas }}</td>
                        <td class="border px-4 py-2">
                            @if ($hotel->images->count())
                                <img src="{{ asset('storage/' . $hotel->images->first()->path) }}"
                                    class="w-20 h-20 object-cover rounded">
                            @else
                                <div
                                    class="w-20 h-20 bg-gray-200 flex items-center justify-center text-xs text-gray-500 rounded">
                                    No Image
                                </div>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('hotels.edit', $hotel) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('hotels.destroy', $hotel) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Yakin mau dihapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>