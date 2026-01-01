<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Blue Ocean Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<!-- ================= REGISTER SECTION ================= -->
<section class="relative min-h-screen flex items-center justify-center">

    <!-- FULL BACKGROUND IMAGE -->
    <img
        src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b"
        class="absolute inset-0 w-full h-full object-cover"
        alt="Hotel Background"
    >

    <!-- DARK OVERLAY -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- REGISTER CARD -->
    <div class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur
                rounded-3xl shadow-2xl px-10 py-12">

        <!-- TITLE -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-blue-700">
                Blue Ocean
            </h1>
            <p class="text-gray-500 mt-2">
                Create your professional account
            </p>
        </div>

        <!-- FORM (ISI ASLI TIDAK DIUBAH) -->
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- NAME -->
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Name
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    class="mt-1 w-full rounded-xl border-gray-300
                           px-4 py-3
                           focus:border-blue-600 focus:ring-blue-600"
                >
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="mt-1 w-full rounded-xl border-gray-300
                           px-4 py-3
                           focus:border-blue-600 focus:ring-blue-600"
                >
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="mt-1 w-full rounded-xl border-gray-300
                           px-4 py-3
                           focus:border-blue-600 focus:ring-blue-600"
                >
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Confirm Password
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="mt-1 w-full rounded-xl border-gray-300
                           px-4 py-3
                           focus:border-blue-600 focus:ring-blue-600"
                >
            </div>

            <!-- ACTION -->
            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('login') }}"
                   class="text-sm text-blue-600 hover:underline">
                    Already registered?
                </a>

                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-700 hover:bg-blue-800
                           text-white font-semibold rounded-xl
                           shadow-lg transition">
                    Register
                </button>
            </div>
        </form>

    </div>
</section>

<!-- ================= SUBSCRIBE SECTION ================= -->
<section class="bg-white py-12">
    <div class="max-w-5xl mx-auto bg-blue-500 rounded-2xl px-8 py-10 text-white">

        <h2 class="text-2xl font-bold mb-2">
            Suscríbete y entérate de nuestras ofertas
        </h2>
        <p class="text-blue-100">
            Recibirás las mejores promociones y descuentos a tu email.
        </p>

    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-white border-t py-12">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-sm text-gray-600">

        <div>
            <h4 class="font-bold mb-2">Compañía</h4>
            <p>Mi cuenta</p>
        </div>

        <div>
            <h4 class="font-bold mb-2">Políticas</h4>
            <p>Términos y condiciones</p>
            <p>Política de privacidad</p>
        </div>

        <div>
            <h4 class="font-bold mb-2">Ayuda</h4>
            <p>Atención al cliente</p>
            <p>Preguntas frecuentes</p>
        </div>

        <div>
            <h4 class="font-bold mb-2">Contáctanos</h4>
            <p>+511 616 9080</p>
            <p class="text-pink-600 font-semibold">Libro de Reclamaciones</p>
        </div>

    </div>
</footer>

</body>
</html>
