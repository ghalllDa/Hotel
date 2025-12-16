<x-app-layout>
    <!-- DASHBOARD ROLE -->
    <div class="bg-blue-50 p-6">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-blue-700 mb-4">
                Penginapan Hotelku
            </h1>
{{-- 
            @if($role === 'user')
                <p class="text-gray-700">Dashboard User</p>
            @elseif($role === 'admin_operasional')
                <p class="text-gray-700">Dashboard Admin Operasional</p>
            @elseif($role === 'admin_konten')
                <p class="text-gray-700">Dashboard Admin Konten & Sistem</p>
            @endif
        </div>
    </div> --}}

    <!-- HERO SECTION -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-400 py-12">
        <div class="max-w-7xl mx-auto px-6 text-white">
            <h1 class="text-3xl font-bold mb-2">
                Booking Hotel & Penginapan Murah
            </h1>
            <p class="text-sm mb-6">
                Temukan hotel terbaik dengan harga promo
            </p>

            <!-- SEARCH BOX -->
            <div class="bg-white rounded-lg shadow-lg p-4 text-gray-700 grid grid-cols-1 md:grid-cols-5 gap-3">
                <input type="text" placeholder="Kota / Hotel"
                       class="border rounded px-3 py-2 col-span-2">

                <input type="date"
                       class="border rounded px-3 py-2">

                <input type="date"
                       class="border rounded px-3 py-2">

                <input type="number" placeholder="Tamu"
                       class="border rounded px-3 py-2">

                <button class="bg-orange-500 hover:bg-orange-600 text-white rounded px-4 py-2">
                    Cari
                </button>
            </div>
        </div>
    </div>

    <!-- PROMO SECTION -->
    <div class="max-w-7xl mx-auto px-6 mt-8">
        <div class="bg-blue-100 rounded-lg p-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-blue-700">
                    Year End Sale 🎉
                </h2>
                <p class="text-sm text-gray-600">
                    Diskon hotel hingga 30%
                </p>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Lihat Promo
            </button>
        </div>
    </div>

    <!-- HOTEL LIST SECTION -->
    <div class="max-w-7xl mx-auto px-6 mt-10">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Rekomendasi Hotel
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- HOTEL CARD -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <img src="https://source.unsplash.com/400x250/?hotel"
                     class="rounded-t-lg w-full h-40 object-cover">

                <div class="p-4">
                    <h3 class="font-semibold text-lg">
                        Hotel Harmoni
                    </h3>

                    <p class="text-sm text-gray-500">
                        Jakarta Pusat
                    </p>

                    <!-- FASILITAS -->
                    <div class="flex gap-2 text-xs text-blue-600 mt-2">
                        <span>WiFi</span>
                        <span>AC</span>
                        <span>Parkir</span>
                    </div>

                    <!-- HARGA -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">
                            Mulai dari
                        </p>
                        <p class="text-lg font-bold text-orange-600">
                            Rp 350.000 / malam
                        </p>
                    </div>

                    <button class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                        Lihat Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
