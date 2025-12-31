<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Blue Ocean Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen relative">

    <!-- FULL BACKGROUND IMAGE -->
    <img
        src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
        class="absolute inset-0 w-full h-full object-cover"
        alt="Hotel Background"
    >

    <!-- DARK OVERLAY -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- CENTER CONTENT -->
    <div class="relative z-10 min-h-screen flex items-center justify-center px-6">

        <!-- LOGIN CARD -->
        <div class="w-full max-w-md bg-white/95 backdrop-blur
                    rounded-3xl shadow-2xl px-10 py-12">

            <!-- TITLE -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-blue-700">
                    Blue Ocean
                </h1>
                <p class="text-gray-500 mt-2">
                    Please sign in to your account
                </p>
            </div>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- FORM (ISI ASLI TIDAK DIUBAH) -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Email Address
                    </label>
                    <input
                        type="email"
                        name="email"
                        required
                        autofocus
                        class="mt-1 w-full rounded-xl border-gray-300
                               px-4 py-3
                               focus:border-blue-600 focus:ring-blue-600"
                    >
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
                </div>

                <!-- OPTIONS -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm">
                        <input type="checkbox"
                               class="rounded text-blue-600 focus:ring-blue-600">
                        <span class="ml-2 text-gray-600">Remember me</span>
                    </label>

                    <a href="{{ route('password.request') }}"
                       class="text-sm text-blue-600 hover:underline">
                        Forgot password?
                    </a>
                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full py-3 bg-blue-700 hover:bg-blue-800
                           text-white font-semibold rounded-xl
                           shadow-lg transition duration-300">
                    Login
                </button>
            </form>

        </div>
    </div>

</body>
</html>
