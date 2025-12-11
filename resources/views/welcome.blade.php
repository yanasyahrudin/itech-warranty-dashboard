<!-- filepath: resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iTech Warranty System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
        <div class="absolute top-0 right-0 p-6">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-200">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-gray-200">Login</a>
            @endauth
        </div>

        <div class="flex items-center justify-center min-h-screen">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h1 class="text-6xl font-bold text-white mb-4">iTech Warranty System</h1>
                <p class="text-xl text-white text-opacity-90 mb-8">
                    Manage your product warranties easily and securely
                </p>

                <div class="grid md:grid-cols-2 gap-6 mt-12">
                    <a href="{{ route('warranty.register') }}" class="bg-white hover:bg-gray-50 rounded-lg shadow-lg p-8 transition transform hover:scale-105">
                        <div class="flex justify-center mb-4">
                            <svg class="h-16 w-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Register Warranty</h3>
                        <p class="text-gray-600">Register your product warranty with us</p>
                    </a>

                    <a href="{{ route('warranty.check') }}" class="bg-white hover:bg-gray-50 rounded-lg shadow-lg p-8 transition transform hover:scale-105">
                        <div class="flex justify-center mb-4">
                            <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Check Status</h3>
                        <p class="text-gray-600">Verify your warranty status</p>
                    </a>
                </div>

                <div class="mt-12 bg-white bg-opacity-20 backdrop-blur-lg rounded-lg p-6">
                    <h4 class="text-white font-semibold mb-3">Quick Features</h4>
                    <div class="grid md:grid-cols-3 gap-4 text-white text-sm">
                        <div>
                            <svg class="h-8 w-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            <p>Universal QR Code</p>
                        </div>
                        <div>
                            <svg class="h-8 w-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p>Easy Verification</p>
                        </div>
                        <div>
                            <svg class="h-8 w-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p>Email Notifications</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>