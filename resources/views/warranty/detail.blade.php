<!-- filepath: resources/views/warranty/detail.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty Details - iTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="{{ route('warranty.check') }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                        ← Back to Check
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
            
            <!-- Status Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <div class="p-8">
                    <!-- Status Badge -->
                    <div class="flex items-center mb-6">
                        <div class="text-5xl mr-4">{{ $warrantyStatus['icon'] }}</div>
                        <div>
                            <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full border {{ $warrantyStatus['badge_class'] }}">
                                {{ $warrantyStatus['label'] }}
                            </span>
                            <p class="text-gray-600 mt-2">{{ $warrantyStatus['description'] }}</p>
                        </div>
                    </div>

                    <!-- Warranty Timeline (if approved) -->
                    @if($warranty->status === 'approved' && $warranty->warranty_start_date && $warranty->warranty_end_date)
                        <div class="mt-8 p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg border border-indigo-200">
                            <h3 class="font-semibold text-gray-900 mb-4">Warranty Coverage Timeline</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Start Date -->
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 font-medium">Warranty Starts</p>
                                    <p class="text-2xl font-bold text-indigo-600 mt-2">{{ $warranty->warranty_start_date->format('d') }}</p>
                                    <p class="text-sm text-gray-600">{{ $warranty->warranty_start_date->format('M Y') }}</p>
                                </div>

                                <!-- Duration -->
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-500 font-medium">Coverage Duration</p>
                                    <p class="text-2xl font-bold text-blue-600 mt-2">{{ $warranty->product->warranty_period_months }}</p>
                                    <p class="text-sm text-gray-600">Months</p>
                                </div>

                                <!-- End Date -->
                                <div class="bg-white p-4 rounded-lg border {{ $warranty->isActive() ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                                    <p class="text-sm {{ $warranty->isActive() ? 'text-green-700' : 'text-red-700' }} font-medium">
                                        Warranty {{ $warranty->isActive() ? 'Expires' : 'Expired' }}
                                    </p>
                                    <p class="text-2xl font-bold {{ $warranty->isActive() ? 'text-green-600' : 'text-red-600' }} mt-2">
                                        {{ $warranty->warranty_end_date->format('d') }}
                                    </p>
                                    <p class="text-sm {{ $warranty->isActive() ? 'text-green-700' : 'text-red-700' }}">
                                        {{ $warranty->warranty_end_date->format('M Y') }}
                                    </p>
                                </div>
                            </div>

                            @if($warranty->isActive())
                                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-sm text-green-800">
                                        ✅ <strong>{{ $daysRemaining }} days remaining</strong> of warranty coverage
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Rejection Reason (if rejected) -->
                    @if($warranty->status === 'rejected' && $warranty->rejection_reason)
                        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <h4 class="font-semibold text-red-900 mb-2">⚠️ Alasan Penolakan Pendaftaran</h4>
                            <p class="text-sm text-red-800">{{ $warranty->rejection_reason }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-xs text-red-600">
                                    Jika Anda yakin ini adalah kesalahan, silakan hubungi tim dukungan kami.
                                </p>
                                <a href="{{ route('warranty.resubmit', $warranty) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition duration-150">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Ajukan Ulang
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Product Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h3>
                    <div class="space-y-4">
                        <div class="border-b border-gray-200 pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Product Name</p>
                            <p class="text-base font-semibold text-gray-900 mt-1">{{ $warranty->product->name }}</p>
                        </div>
                        <div class="border-b border-gray-200 pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Product Type</p>
                            <p class="text-base font-semibold text-gray-900 mt-1">{{ $warranty->product->type }}</p>
                        </div>
                        <div class="border-b border-gray-200 pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Part Number</p>
                            <p class="text-base font-semibold text-indigo-600 mt-1">{{ $warranty->product->part_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Serial Number</p>
                            <p class="text-base font-semibold text-gray-900 mt-1 font-mono">{{ $warranty->serial_number }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                    <div class="space-y-4">
                        <div class="border-b border-gray-200 pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Name</p>
                            <p class="text-base font-semibold text-gray-900 mt-1">{{ $warranty->customer_name }}</p>
                        </div>
                        <div class="border-b border-gray-200 pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Email</p>
                            <p class="text-base font-semibold text-gray-900 mt-1">{{ $warranty->customer_email }}</p>
                        </div>
                        <div class="border-b border-gray-200 pb-3">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Phone</p>
                            <p class="text-base font-semibold text-gray-900 mt-1">{{ $warranty->customer_phone }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Registered Date</p>
                            <p class="text-base font-semibold text-gray-900 mt-1">{{ $warranty->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Status Timeline -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Registration History</h3>
                
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-6 top-0 bottom-0 w-1 bg-gradient-to-b from-indigo-300 to-indigo-100"></div>

                    <!-- Timeline Items -->
                    <div class="space-y-6 relative">
                        <!-- Submitted -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 border-4 border-white">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-900">Registration Submitted</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $warranty->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Verification Status -->
                        @if($warranty->status === 'pending')
                            <div class="flex items-start opacity-50">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 border-4 border-white">
                                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-semibold text-gray-900">Awaiting Verification</p>
                                    <p class="text-xs text-gray-500 mt-1">Typically verified within 1-2 business days</p>
                                </div>
                            </div>
                        @elseif($warranty->status === 'approved')
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 border-4 border-white">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-semibold text-gray-900">Registration Approved</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $warranty->verified_at?->format('d M Y, H:i') ?? 'Verified' }}</p>
                                </div>
                            </div>
                        @elseif($warranty->status === 'rejected')
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 border-4 border-white">
                                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-semibold text-gray-900">Registration Rejected</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $warranty->rejected_at?->format('d M Y, H:i') ?? 'Rejected' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-2">📞 Need Help?</h3>
                <p class="text-sm text-blue-800 mb-4">
                    If you have any questions about your warranty status, please contact our support team:
                </p>
                <div class="flex flex-col space-y-2">
                    <p class="text-sm text-blue-800"><strong>Email:</strong> support@itech.com</p>
                    <p class="text-sm text-blue-800"><strong>Phone:</strong> +62 XXX-XXXX-XXXX</p>
                    <p class="text-sm text-blue-800"><strong>Hours:</strong> Monday - Friday, 09:00 - 17:00 WIB</p>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('warranty.check') }}" 
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition duration-150">
                    ← Check Another Serial Number
                </a>
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
</body>
</html>