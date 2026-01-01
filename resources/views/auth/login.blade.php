<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Blue Ocean Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<!-- ================= LOGIN SECTION ================= -->
<section class="relative min-h-screen flex items-center justify-center">

    <!-- BACKGROUND -->
    <img
        src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
        class="absolute inset-0 w-full h-full object-cover"
        alt="Hotel Background"
    >
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- LOGIN CARD -->
    <div class="relative z-10 w-full max-w-md bg-white/95 backdrop-blur
                rounded-3xl shadow-2xl px-10 py-12">

        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-blue-700">Blue Ocean</h1>
            <p class="text-gray-500 mt-2">Please sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label class="text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" required
                       class="mt-1 w-full rounded-xl border-gray-300 px-4 py-3">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="mt-1 w-full rounded-xl border-gray-300 px-4 py-3">
            </div>

            <div class="flex justify-between text-sm">
                <label class="flex items-center">
                    <input type="checkbox" class="rounded">
                    <span class="ml-2">Remember me</span>
                </label>

                <a href="{{ route('password.request') }}" class="text-blue-600">
                    Forgot password?
                </a>
            </div>

            <button class="w-full py-3 bg-blue-700 text-white rounded-xl font-semibold">
                Login
            </button>
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
