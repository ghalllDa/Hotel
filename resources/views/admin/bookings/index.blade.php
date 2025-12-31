<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-8">

        <h1 class="text-2xl font-bold mb-6">📋 Daftar Pesanan</h1>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Hotel</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Kamar</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Total</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                {{ $booking->nama_pemesan }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $booking->room->hotel->nama_hotel ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $booking->room->nama_kamar ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-3">
                                @if($booking->status === 'paid')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                        PAID
                                    </span>
                                @elseif($booking->status === 'pending')
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                        PENDING
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                        {{ strtoupper($booking->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center space-x-2">
                                @if($booking->status === 'paid')
                                    <form method="POST"
                                          action="{{ route('admin.bookings.approve', $booking->id) }}"
                                          class="inline">
                                        @csrf
                                        <button
                                            class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                                            Terima
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('admin.bookings.reject', $booking->id) }}"
                                          class="inline">
                                        @csrf
                                        <button
                                            class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                                            Tolak
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">
                                Belum ada pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
