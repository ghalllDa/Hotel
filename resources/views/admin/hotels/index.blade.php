<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-8">

            {{-- HEADER (FIX FINAL, TIDAK JELEK) --}}
            <div class="mb-8">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 text-sm text-gray-500
                          hover:text-gray-700 mb-4">
                    ← Dashboard
                </a>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        {{-- ICON --}}
                        <div class="w-12 h-12 rounded-xl bg-blue-100
                                    flex items-center justify-center
                                    text-blue-600 text-xl">
                            🏨
                        </div>

                        {{-- TITLE --}}
                        <div>
                            <div class="flex items-center gap-2">
                                <h1 class="text-2xl font-bold text-gray-900">
                                    Daftar Hotel
                                </h1>
                                <span class="px-2.5 py-0.5 rounded-full
                                             text-xs font-semibold
                                             bg-blue-50 text-blue-600">
                                    Admin
                                </span>
                            </div>
                            <p class="text-sm text-gray-500">
                                Kelola hotel yang terdaftar
                            </p>
                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <a href="{{ route('hotels.create') }}"
                       class="inline-flex items-center gap-2
                              px-5 py-2.5 rounded-xl
                              bg-blue-600 text-white font-semibold
                              hover:bg-blue-700 transition shadow-md">
                        + Tambah Hotel
                    </a>
                </div>

                {{-- DIVIDER --}}
                <div class="mt-6 h-px bg-gradient-to-r
                            from-transparent via-gray-300 to-transparent"></div>
            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-left">Hotel</th>
                            <th class="px-6 py-4 text-left">Bintang</th>
                            <th class="px-6 py-4 text-left">Lokasi</th>
                            <th class="px-6 py-4 text-left">Harga</th>
                            <th class="px-6 py-4 text-left">Fasilitas</th>
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

                            <tr class="hover:bg-blue-50/40 transition">

                                {{-- HOTEL --}}
                                <td class="px-6 py-5">
                                    <div class="font-semibold text-gray-900">
                                        {{ $hotel->nama_hotel }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        ID #{{ $hotel->id }}
                                    </div>
                                </td>

                                {{-- BINTANG --}}
                                <td class="px-6 py-5 text-yellow-500 text-base">
                                    @for ($i = 1; $i <= $bintang; $i++)
                                        ★
                                    @endfor
                                </td>

                                {{-- LOKASI --}}
                                <td class="px-6 py-5 text-gray-700">
                                    {{ ucfirst($hotel->lokasi) }}
                                </td>

                                {{-- HARGA --}}
                                <td class="px-6 py-5 font-bold text-gray-900">
                                    Rp {{ number_format($hotel->harga, 0, ',', '.') }}
                                </td>

                                {{-- FASILITAS --}}
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 rounded-full
                                                 bg-orange-100 text-orange-700
                                                 text-xs font-semibold">
                                        {{ $hotel->fasilitas }}
                                    </span>
                                </td>

                                {{-- GAMBAR --}}
                                <td class="px-6 py-5 text-center">
                                    @if($gambar)
                                        <img src="{{ asset('storage/'.$gambar->path) }}"
                                             class="w-20 h-14 object-cover
                                                    rounded-xl shadow-md mx-auto">
                                    @else
                                        <span class="text-xs text-gray-400 italic">
                                            No Image
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-6 py-5 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('hotels.edit', $hotel->id) }}"
                                           class="px-4 py-2 rounded-lg
                                                  bg-blue-100 text-blue-700
                                                  font-semibold hover:bg-blue-200 transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('hotels.destroy', $hotel->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin hapus hotel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-4 py-2 rounded-lg
                                                           bg-red-100 text-red-700
                                                           font-semibold hover:bg-red-200 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
