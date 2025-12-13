<!-- filepath: resources/views/warranty/check.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Warranty Status - iTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gradient-to-r from-gray-400 to-gray-600">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-gray-600">
                        <img src="https://res.cloudinary.com/dcbryptkx/image/upload/v1765004406/itech-warranty-qr/LogoItech_z57jdx.png" alt="" class="h-14 w-auto">
                    </div>
                    <span class="hidden lg:block ml-2 text-gray-600">Sistem Garansi</span>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('warranty.check') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        Cek Garansi
                    </a>
                    <a href="/" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        Beranda
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">

            <!-- Page Title -->
            <div class="text-center mb-12 text-white">
                <h1 class="text-4xl font-bold mb-4">Cek Status Garansi</h1>
                <p class="text-lg">Masukkan nomor seri Anda untuk memeriksa status garansi</p>
            </div>

            <!-- Search Box -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <form method="POST" action="{{ route('warranty.search') }}" id="searchForm">
                    @csrf

                    <div class="mb-6">
                        <label for="serial_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            Serial Number
                        </label>
                        <div class="relative">
                            <input type="text"
                                name="serial_number"
                                id="serial_number"
                                placeholder="e.g., CASE-FULL-TOWER-01-00001"
                                value="{{ old('serial_number') }}"
                                class="rounded-xl w-full px-3 py-2 shadow-[0_2px_4px_rgba(0,0,0,0.15)] @error('serial_number') border-red-500 @enderror"
                                style="text-transform: uppercase;"
                                autocomplete="off"
                                required>
                            <button type="submit"
                                class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-xl transition duration-150">
                                Search
                            </button>
                        </div>
                        @error('serial_number')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </form>

                <!-- Info Box -->
                <div class="mt-6 p-4 bg-gradient-to-r from-gray-100 to-gray-300 rounded-xl">
                    <h3 class="font-semibold text-gray-900 mb-2">Cara menemukan Nomor Seri Anda:</h3>
                    <ul class="text-sm text-gray-800 space-y-1 list-disc list-inside">
                        <li>Periksa label produk yang terpasang pada perangkat Anda</li>
                        <li>Cari kode yang diawali dengan nomor bagian produk</li>
                        <li>Contoh: <code class="bg-gray-600 text-white px-2 py-1 rounded-xl">CASE-FULL-TOWER-01-00001</code></li>
                        <li>Anda juga dapat memindai kode QR pada label</li>
                    </ul>
                </div>
            </div>

            <!-- Recent Searches (Optional) -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Pencarian Terbaru</h2>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>Cobalah mencari nomor seri untuk melihat detail garansi</p>
                </div>
            </div>

        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-gray-100 to-gray-300 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Tentang Itech Warranty Dashboard</h3>
                        <p class="text-sm text-gray-600">Sistem manajemen garansi profesional untuk produk berkualitas</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Tautan Cepat</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><a href="{{ route('warranty.register') }}" class="hover:text-gray-600">Daftar Garansi</a></li>
                            <li><a href="{{ route('warranty.check') }}" class="hover:text-gray-600">Periksa Garansi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Dukungan</h3>
                        <p class="text-sm text-gray-600">Email: xxx@xxx.com</p>
                        <p class="text-sm text-gray-600">Telepon: +62 811-7531-881</p>
                    </div>
                </div>
                <div class="border-gray-200 mt-8 pt-4 text-center text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} PT. Itech Persada Nusantara. Semua Hak Dilindungi Undang-Undang.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Auto uppercase serial number
        document.getElementById('serial_number').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    </script>
</body>

</html>