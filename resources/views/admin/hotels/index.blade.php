<x-app-layout>

    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto px-6 mt-8 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('dashboard') }}"
                   class="text-sm text-gray-400 hover:text-blue-600 transition">
                    ← Dashboard
                </a>

                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2 mt-2">
                    🏨 Daftar Hotel
                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">
                        Admin
                    </span>
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    Kelola hotel yang terdaftar
                </p>
            </div>

            <a href="{{ route('hotels.create') }}"
               class="bg-blue-600 hover:bg-blue-700
                      transition text-white px-5 py-2 rounded-lg shadow">
                + Tambah Hotel
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="max-w-7xl mx-auto px-6 pb-16">
        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Hotel</th>
                        <th class="px-6 py-4 text-center">Bintang</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Fasilitas</th>
                        <th class="px-6 py-4 text-center">Gambar</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach($hotels as $hotel)
                        @php
                            $bintang = (int) ($hotel->stars ?? 0);
                            $gambar  = $hotel->images->first();
                        @endphp

                        <tr class="hover:bg-gray-50 transition">

                            {{-- HOTEL --}}
                            <td class="px-6 py-5">
                                <p class="font-semibold text-gray-800">
                                    {{ $hotel->nama_hotel }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    ID #{{ $hotel->id }}
                                </p>
                            </td>

                            {{-- BINTANG --}}
                            <td class="px-6 py-5 text-center">
                                @for ($i = 1; $i <= $bintang; $i++)
                                    <span class="text-yellow-400">★</span>
                                @endfor
                            </td>

                            {{-- LOKASI --}}
                            <td class="px-6 py-5 text-gray-700">
                                {{ $hotel->lokasi }}
                            </td>

                            {{-- HARGA --}}
                            <td class="px-6 py-5 font-semibold text-gray-800">
                                Rp {{ number_format($hotel->harga, 0, ',', '.') }}
                            </td>

                            {{-- FASILITAS --}}
                            <td class="px-6 py-5">
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $hotel->fasilitas) as $f)
                                        <span class="text-xs bg-orange-50 text-orange-600
                                                     px-3 py-1 rounded-full">
                                            {{ trim($f) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            {{-- GAMBAR --}}
                            <td class="px-6 py-5 text-center">
                                @if($gambar)
                                    <img src="{{ asset('storage/' . $gambar->path) }}"
                                         class="w-14 h-14 object-cover rounded-lg shadow mx-auto">
                                @else
                                    <div class="w-14 h-14 bg-gray-200 rounded-lg mx-auto"></div>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-5 text-center">
                                <div class="flex justify-center gap-2">

                                    {{-- EDIT --}}
                                    <a href="{{ route('hotels.edit', $hotel->id) }}"
                                       class="px-4 py-1.5 rounded-lg text-sm
                                              bg-blue-100 text-blue-700
                                              hover:bg-blue-600 hover:text-white
                                              transition shadow-sm">
                                        Edit
                                    </a>

                                    {{-- HAPUS --}}
                                    <button
                                        onclick="openDeleteModal({{ $hotel->id }})"
                                        class="px-4 py-1.5 rounded-lg text-sm
                                               bg-red-100 text-red-600
                                               hover:bg-red-600 hover:text-white
                                               transition shadow-sm">
                                        Hapus
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div id="deleteModal"
         class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">

            <h2 class="text-lg font-bold text-gray-800 mb-2">
                ⚠️ Konfirmasi Hapus
            </h2>

            <p class="text-gray-600 text-sm mb-6">
                Data hotel akan dihapus permanen dan tidak bisa dikembalikan.
            </p>

            <div class="flex justify-end gap-3">
                <button onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded-lg bg-gray-100
                               hover:bg-gray-200 transition">
                    Batal
                </button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg
                                   bg-red-600 text-white
                                   hover:bg-red-700 transition">
                        Ya, Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- SCRIPT MODAL --}}
    <script>
        function openDeleteModal(id) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
            document.getElementById('deleteForm').action = `/admin-operasional/hotels/${id}`;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }
    </script>

</x-app-layout>
