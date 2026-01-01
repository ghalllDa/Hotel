<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Pesanan
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('dashboard') }}"
                   class="text-blue-600 hover:text-blue-800 text-sm">
                    ← Kembali ke Dashboard
                </a>
            </div>

            @if ($orders->isEmpty())
                <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                    Belum ada riwayat pesanan
                </div>
            @else
                <div class="bg-white rounded-lg shadow overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">Kode Booking</th>
                                <th class="px-4 py-3 text-left">Hotel</th>
                                <th class="px-4 py-3 text-left">Kamar</th>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">Total</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($orders as $order)
                                @php
                                    $status = strtolower($order->status);
                                @endphp

                                <tr>
                                    <td class="px-4 py-3">
                                        {{ $order->transaction_id ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $order->hotel->nama_hotel ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $order->room->nama_kamar ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($order->check_in)->format('d M Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($order->check_out)->format('d M Y') }}
                                    </td>

                                    <td class="px-4 py-3 font-semibold text-orange-600">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($status === 'pending')
                                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                                Menunggu Pembayaran
                                            </span>
                                        @elseif ($status === 'paid')
                                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
                                                Menunggu Konfirmasi Admin
                                            </span>
                                        @elseif ($status === 'approved')
                                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                                Disetujui
                                            </span>
                                        @elseif ($status === 'rejected')
                                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                                Ditolak
                                            </span>
                                        @elseif ($status === 'completed')
                                            <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-600">
                                                Unknown
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($status === 'approved' && $order->ticket)
                                            <a href="{{ route('tickets.show', $order->ticket->id) }}"
                                               class="inline-block bg-green-600 text-white px-3 py-1 rounded text-xs">
                                                Lihat Tiket
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
