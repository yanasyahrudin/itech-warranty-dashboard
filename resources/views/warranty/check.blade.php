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
<body class="bg-gradient-to-br from-indigo-50 to-blue-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-indigo-600">🔧 iTech</div>
                    <span class="ml-2 text-gray-600">Warranty System</span>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('warranty.register') }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                        Register Warranty
                    </a>
                    <a href="/" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        Home
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
            
            <!-- Page Title -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Check Warranty Status</h1>
                <p class="text-lg text-gray-600">Enter your serial number to check your warranty status</p>
            </div>

            <!-- Search Box -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
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
                                class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('serial_number') border-red-500 @enderror"
                                style="text-transform: uppercase;"
                                autocomplete="off"
                                required>
                            <button type="submit" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150">
                                🔍 Search
                            </button>
                        </div>
                        @error('serial_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </form>

                <!-- Info Box -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="font-semibold text-blue-900 mb-2">💡 How to find your Serial Number:</h3>
                    <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                        <li>Check the product label attached to your device</li>
                        <li>Look for a code starting with the product part number</li>
                        <li>Example: <code class="bg-blue-100 px-2 py-1 rounded">CASE-FULL-TOWER-01-00001</code></li>
                        <li>You can also scan the QR code on the label</li>
                    </ul>
                </div>
            </div>

            <!-- Recent Searches (Optional) -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Searches</h2>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>👉 Try searching for a serial number to see warranty details</p>
                </div>
            </div>

        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">About iTech</h3>
                        <p class="text-sm text-gray-600">Professional warranty management system for quality products</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Quick Links</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><a href="{{ route('warranty.register') }}" class="hover:text-indigo-600">Register Warranty</a></li>
                            <li><a href="{{ route('warranty.check') }}" class="hover:text-indigo-600">Check Warranty</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Support</h3>
                        <p class="text-sm text-gray-600">Email: support@itech.com</p>
                        <p class="text-sm text-gray-600">Phone: +62 XXX-XXXX-XXXX</p>
                    </div>
                </div>
                <div class="border-t border-gray-200 mt-8 pt-8 text-center text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} iTech. All rights reserved.</p>
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