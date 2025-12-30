<x-app-layout>

<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Daftar Promo Kamar</h1>
        <a href="{{ route('promo.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            + Tambah Promo
        </a>
    </div>

    <input type="text"
           placeholder="Cari hotel / kamar / promo..."
           class="mb-4 w-full max-w-md rounded-lg border-gray-300">

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Hotel</th>
                    <th class="p-3 text-left">Kamar</th>
                    <th class="p-3 text-center">Diskon</th>
                    <th class="p-3 text-center">Periode</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                <tr class="border-t">
                    <td class="p-3 font-medium">
                        {{ $promo->room->hotel->nama_hotel }}
                    </td>
                    <td class="p-3">
                        {{ $promo->room->nama_kamar }}
                    </td>
                    <td class="p-3 text-center">
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $promo->diskon }}%
                        </span>
                    </td>
                    <td class="p-3 text-center text-gray-600">
                        {{ $promo->tanggal_mulai }}<br>
                        {{ $promo->tanggal_selesai }}
                    </td>

                    <!-- ⬇️ AKSI -->
                    <td class="p-3 text-center space-x-2">
                        <a href="{{ route('promo.edit', $promo->id) }}"
                           class="px-3 py-1 text-xs bg-yellow-500 text-white rounded">
                            Edit
                        </a>

                        <form action="{{ route('promo.destroy', $promo->id) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Hapus promo ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 text-xs bg-red-600 text-white rounded">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        Belum ada promo
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</x-app-layout>
