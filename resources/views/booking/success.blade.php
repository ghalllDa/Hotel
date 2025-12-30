<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4">
        <div class="max-w-3xl mx-auto">

            <!-- Card Utama -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

                <!-- Header Hijau Sukses -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-12 text-center">
                    <div
                        class="mx-auto w-24 h-24 bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-white mb-2">
                        Pembayaran Berhasil!
                    </h1>
                    <p class="text-green-100 text-lg">
                        Booking kamar Anda telah dikonfirmasi
                    </p>
                </div>

                <!-- Body Detail -->
                <div class="p-8 md:p-10">
                    <p class="text-gray-700 text-lg mb-8 text-center">
                        Terima kasih, <strong class="text-gray-900">{{ $booking->nama_pemesan }}</strong>!
                        Kami sudah menerima pembayaran Anda.
                    </p>

                    <!-- Detail Booking dalam Card -->
                    <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Nama Kamar</span>
                            <span class="font-bold text-gray-900">{{ $booking->room->nama_kamar }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Check-in</span>
                            <span class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->check_in)->format('d F Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Check-out</span>
                            <span class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->check_out)->format('d F Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Jumlah Tamu</span>
                            <span class="font-semibold text-gray-900">{{ $booking->jumlah_tamu }} orang</span>
                        </div>
                        <hr class="border-gray-300">
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-gray-700 font-semibold">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-orange-600">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="mt-10 text-center">
                        <a href="{{ url('/dashboard') }}"
                            class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-10 rounded-xl text-lg transition shadow-md hover:shadow-lg">
                            Kembali ke Beranda
                        </a>
                    </div>


                </div>
            </div>

        </div>
    </div>
</x-app-layout>