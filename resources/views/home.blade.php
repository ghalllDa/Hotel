<x-app-layout>
    <!-- HERO SECTION -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-400 py-20">
        <div class="max-w-7xl mx-auto px-6 text-white text-center">
            <h1 class="text-4xl font-bold mb-4">
                Booking Hotel & Penginapan Murah
            </h1>
            <p class="mb-6">
                Temukan hotel terbaik dengan harga promo
            </p>

            <!-- BUTTON LOGIN & REGISTER -->
            <div class="space-x-4 mt-6">
                <a href="{{ route('login') }}" class="bg-white text-blue-600 font-semibold px-6 py-2 rounded hover:bg-gray-100">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-orange-500 text-white font-semibold px-6 py-2 rounded hover:bg-orange-600">
                    Register
                </a>
            </div>
        </div>
    </div>

    <!-- PROMO SECTION -->
    <div class="max-w-7xl mx-auto px-6 mt-10">
        <div class="bg-blue-100 p-6 rounded-lg flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-blue-700">
                    Year End Sale 🎉
                </h2>
                <p>Diskon hotel hingga 30%</p>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Lihat Promo
            </button>
        </div>
    </div>
</x-app-layout>
