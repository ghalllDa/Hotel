<x-app-layout>

    <!-- HERO SECTION -->
    <section class="relative h-[85vh] flex items-center justify-center">

        <!-- BACKGROUND IMAGE -->
        <img 
            src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
            class="absolute inset-0 w-full h-full object-cover"
            alt="Hotel Background"
        >

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-blue-600/60"></div>

        <!-- CONTENT -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 text-white text-center">
            <h1 class="text-5xl font-bold mb-4">
                Booking Hotel & Penginapan Murah
            </h1>
            <p class="mb-8 text-lg">
                Temukan hotel terbaik dengan harga promo
            </p>

            <!-- BUTTON LOGIN & REGISTER -->
            <div class="space-x-4 mt-6">
                <a href="{{ route('login') }}"
                   class="bg-white text-blue-700 font-semibold px-8 py-3 rounded-xl
                          shadow hover:bg-gray-100 transition">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="bg-orange-500 text-white font-semibold px-8 py-3 rounded-xl
                          shadow hover:bg-orange-600 transition">
                    Register
                </a>
            </div>
        </div>
    </section>

    <!-- PROMO SECTION -->
    <section class="max-w-7xl mx-auto px-6 -mt-20 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl p-8
                    flex flex-col md:flex-row justify-between items-center">

            <div>
                <h2 class="text-2xl font-bold text-blue-700">
                    Year End Sale 🎉
                </h2>
                <p class="text-gray-600 mt-1">
                    Diskon hotel hingga 30%
                </p>
            </div>

            <button class="mt-4 md:mt-0 bg-blue-600 text-white px-6 py-3
                           rounded-xl hover:bg-blue-700 transition">
                Lihat Promo
            </button>
        </div>
    </section>

</x-app-layout>
