<x-app-layout>
    <div class="max-w-5xl mx-auto px-6 py-8">

        <!-- JUDUL -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Booking Kamar
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- FORM BOOKING -->
            <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold mb-4">Detail Pemesanan</h2>

                <form action="#" method="POST" class="space-y-4">
                    @csrf

                    <!-- CHECK IN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Tanggal Check-in
                        </label>
                        <input type="date" name="check_in"
                               class="w-full mt-1 border rounded-lg px-3 py-2">
                    </div>

                    <!-- CHECK OUT -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Tanggal Check-out
                        </label>
                        <input type="date" name="check_out"
                               class="w-full mt-1 border rounded-lg px-3 py-2">
                    </div>

                    <!-- JUMLAH TAMU -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Jumlah Tamu
                        </label>
                        <input type="number" name="jumlah_tamu" min="1"
                               class="w-full mt-1 border rounded-lg px-3 py-2">
                    </div>

                    <!-- NAMA PEMESAN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Nama Pemesan
                        </label>
                        <input type="text" name="nama_pemesan"
                               class="w-full mt-1 border rounded-lg px-3 py-2">
                    </div>

                    <!-- NO HP -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            No. HP
                        </label>
                        <input type="text" name="no_hp"
                               class="w-full mt-1 border rounded-lg px-3 py-2">
                    </div>

                    <!-- CATATAN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Catatan (opsional)
                        </label>
                        <textarea name="catatan"
                                  class="w-full mt-1 border rounded-lg px-3 py-2"></textarea>
                    </div>

                    <!-- SUBMIT -->
                    <button type="submit"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-bold transition">
                        Konfirmasi Booking
                    </button>
                </form>
            </div>

            <!-- RINGKASAN KAMAR -->
            <div class="bg-white rounded-lg shadow p-6 h-fit">
                <h2 class="text-lg font-bold mb-4">Ringkasan Kamar</h2>

                <!-- FOTO KAMAR -->
                <div class="w-full h-40 mb-4">
                    @if ($room->foto)
                        <img src="{{ asset('storage/' . $room->foto) }}"
                             class="w-full h-full object-cover rounded-lg">
                    @else
                        <img src="/img/no-image.png"
                             class="w-full h-full object-cover rounded-lg">
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
