<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow">

        <h1 class="text-2xl font-bold mb-4">Daftar Hotel</h1>

        <a href="{{ route('hotels.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            Tambah Hotel
        </a>

        <table class="w-full table-auto border">
            <thead class="bg-blue-100">
                <tr>
                    <th class="border px-4 py-2">Nama Hotel</th>
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
                        <td class="border px-4 py-2">{{ $hotel->lokasi }}</td>

                        {{-- HARGA FIX --}}
                        <td class="border px-4 py-2">
                            Rp {{ number_format($hotel->harga, 0, ',', '.') }}
                        </td>

                        <td class="border px-4 py-2">{{ $hotel->fasilitas }}</td>
                        <td class="border px-4 py-2">
                            @if($hotel->gambar)
                                <img src="{{ asset('storage/'.$hotel->gambar) }}"
                                     class="w-20 h-20 object-cover rounded">
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('hotels.edit', $hotel) }}"
                               class="text-blue-600">Edit</a>
                            <form action="{{ route('hotels.destroy', $hotel) }}"
                                  method="POST"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600"
                                        onclick="return confirm('Yakin mau dihapus?')">
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
