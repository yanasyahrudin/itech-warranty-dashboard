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
    <div class="bg-white rounded-2xl shadow-xl w-11/12 sm:w-96 p-8">
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('https://res.cloudinary.com/dcbryptkx/image/upload/v1765004406/itech-warranty-qr/LogoItech_z57jdx.png') }}" alt="Itech Warranty QR" class="w-28 mb-3">
            <h2 class="text-2xl font-semibold text-gray-800">Daftar</h2>
            <p class="text-sm text-gray-500">Buat akun baru untuk mengakses dashboard</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <!-- Name -->
            <div>
                <label for="name" :value="__('Name')" class="block text-gray-700 mb-2 text-sm">Nama Lengkap</label>
                <input id="name" class="rounded-xl w-full px-3 py-2 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)]" type="text" name="name" :value="old('name')" placeholder="Masukkan nama lengkap" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" :value="__('Email')" class="block text-gray-700 mb-2 text-sm">Email</label>
                <input id="email" class="rounded-xl w-full px-3 py-2 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)]" type="email" name="email" :value="old('email')" placeholder="Masukkan email" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" :value="__('Password')" class="block text-gray-700 mb-2 text-sm">Password</label>
                <input id="password" class="rounded-xl w-full px-3 py-2 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)]" type="password" name="password" placeholder="Masukkan password" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" :value="__('Confirm Password')" class="block text-gray-700 mb-2 text-sm">Konfirmasi Password</label>
                <input id="password_confirmation" class="rounded-xl w-full px-3 py-2 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)]" type="password" name="password_confirmation" placeholder="Konfirmasi password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4 mb-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Sudah punya akun? Masuk') }}
                </a>

            </div>
            <button type="submit" class="w-full bg-gray-500 text-white py-2 rounded-xl hover:bg-gray-700 transition duration-200 font-medium">
                Daftar
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-6 text-center text-xs text-gray-500">
            © {{ date('Y') }} PT. Itech Persada Nusantara. Semua hak dilindungi.
        </div>
    </div>
</body>

</html>