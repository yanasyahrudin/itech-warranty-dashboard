<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Itech Warranty QR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dcbryptkx/image/upload/v1765004709/itech-warranty-qr/Logo_ITech_1_rgfmpq_wgcrrq.png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen my-4 bg-gradient-to-r from-gray-400 to-gray-600 flex items-center justify-center">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="bg-white rounded-2xl shadow-xl w-11/12 sm:w-96 p-8">
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('https://res.cloudinary.com/dcbryptkx/image/upload/v1765004709/itech-warranty-qr/Logo_ITech_1_rgfmpq_wgcrrq.png') }}" alt="Itech Warranty QR" class="w-20 mb-3">
            <h2 class="text-2xl font-semibold text-gray-800">Login</h2>
            <p class="text-sm text-gray-500">Akses Itech Warranty Dashboard</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <!-- Email Address -->
            <div>
                <label class="block text-gray-700 mb-2 text-sm" for="email" :value="__('Email')">Email</label>
                <input class="rounded-xl w-full border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" id="email" type="email" name="email" placeholder="Masukkan email" :value="old('email')" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 mb-2 text-sm" for="password" :value="__('Password')">Password</label>
                <input class="rounded-xl w-full border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" id="password" type="password" name="password" placeholder="Masukkan password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4 mb-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
                @endif

            </div>
            <button type="submit"
                class="w-full bg-gray-500 text-white py-2 rounded-xl hover:bg-gray-700 transition duration-200 font-medium">
                Masuk
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-6 text-center text-xs text-gray-500">
            © {{ date('Y') }} PT. Itech Persada Nusantara. Semua hak dilindungi.
        </div>
    </div>
</body>

</html>