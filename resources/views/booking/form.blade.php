<x-app-layout>
    <div class="max-w-5xl mx-auto px-6 py-8">

        <!-- TOMBOL KEMBALI -->
        <a href="{{ route('hotels.show', $room->hotel->id) }}" class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full
          bg-white shadow-sm border border-gray-200
          text-sm font-semibold text-gray-700
          hover:bg-gray-50 hover:text-orange-600
          transition">


            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <!-- JUDUL -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Booking Kamar
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- FORM BOOKING -->
            <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold mb-4">Detail Pemesanan</h2>

                <form action="{{ route('booking.createPayment') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <!-- CHECK IN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Tanggal Check-in
                        </label>
                        <input type="date" name="check_in" class="w-full mt-1 border rounded-lg px-3 py-2" required
                            min="{{ date('Y-m-d') }}">
                        @error('check_in')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- CHECK OUT -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Tanggal Check-out
                        </label>
                        <input type="date" name="check_out" class="w-full mt-1 border rounded-lg px-3 py-2" required
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('check_out')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- JUMLAH TAMU -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Jumlah Tamu
                        </label>
                        <input type="number" name="jumlah_tamu" min="1" class="w-full mt-1 border rounded-lg px-3 py-2"
                            required>
                        @error('jumlah_tamu')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- NAMA PEMESAN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Nama Pemesan
                        </label>
                        <input type="text" name="nama_pemesan" class="w-full mt-1 border rounded-lg px-3 py-2" required>
                    </div>

                    <!-- NO HP -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            No. HP
                        </label>
                        <input type="text" name="no_hp" class="w-full mt-1 border rounded-lg px-3 py-2" required>
                    </div>

                    <!-- CATATAN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Catatan (opsional)
                        </label>
                        <textarea name="catatan" class="w-full mt-1 border rounded-lg px-3 py-2"></textarea>
                    </div>

                    <!-- SUBMIT -->
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-bold transition">
                        Konfirmasi & Lanjut ke Pembayaran
                    </button>
                </form>
            </div>

            <!-- RINGKASAN KAMAR -->
            <div class="bg-white rounded-lg shadow p-6 h-fit">
                <h2 class="text-lg font-bold mb-4">Ringkasan Kamar</h2>

                <!-- FOTO KAMAR -->
                <div class="w-full md:w-50 h-35 flex-shrink-0">
                    @if($room->gambar)
                        <img src="{{ asset('storage/' . $room->gambar) }}" class="w-full h-40 object-cover rounded-lg mb-3">
                    @endif
                </div>


                <!-- HOTEL -->
                <p class="font-semibold text-gray-800">
                    {{ $room->hotel->nama_hotel }}
                </p>
                <p class="text-sm text-gray-500 mb-2">
                    {{ $room->hotel->lokasi }}
                </p>

                <hr class="my-3">

                <!-- KAMAR -->
                <p class="font-semibold text-gray-800">
                    {{ $room->nama_kamar }}
                </p>

                <!-- FASILITAS -->
                <ul class="text-sm text-gray-600 list-disc list-inside mt-1">
                    @foreach ($room->fasilitas as $f)
                        <li>{{ $f }}</li>
                    @endforeach
                </ul>

                <p class="text-sm text-gray-500 mt-2">
                    Kapasitas: {{ $room->kapasitas }} orang
                </p>

                <hr class="my-3">

                <!-- HARGA -->
                <p class="text-sm text-gray-500">Harga / malam</p>
                <p class="text-xl font-bold text-orange-600">
                    Rp {{ number_format($room->harga, 0, ',', '.') }}
                </p>
            </div>

        </div>
    </div>
</x-app-layout>