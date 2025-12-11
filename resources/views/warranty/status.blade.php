<!-- filepath: resources/views/warranty/status.blade.php -->
<x-guest-layout>
    <div class="mb-6">
        <a href="{{ route('warranty.check') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
            ← Back to check
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Warranty Status</h2>
            <p class="text-gray-600">Serial Number: <strong>{{ $registration->serial_number }}</strong></p>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @if($registration->status === 'pending')
                <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800">Pending Review</p>
                            <p class="text-xs text-yellow-700 mt-1">Your warranty registration is pending admin verification. Please wait for confirmation within 3 business days.</p>
                        </div>
                    </div>
                </div>
            @elseif($registration->status === 'approved')
                <div class="p-4 bg-green-50 border-l-4 border-green-400 rounded">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-green-800">Warranty Active</p>
                            <p class="text-xs text-green-700 mt-1">Your warranty has been approved and is now active.</p>
                        </div>
                    </div>
                </div>
            @elseif($registration->status === 'rejected')
                <div class="p-4 bg-red-50 border-l-4 border-red-400 rounded">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-red-800">Warranty Rejected</p>
                            <p class="text-xs text-red-700 mt-1">{{ $registration->rejection_reason ?? 'Your warranty registration has been rejected.' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Product Info -->
            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Product Name</dt>
                        <dd class="text-sm text-gray-900">{{ $registration->product->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Part Number</dt>
                        <dd class="text-sm text-gray-900">{{ $registration->product->part_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Product Type</dt>
                        <dd class="text-sm text-gray-900">{{ $registration->product->type }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Warranty Period</dt>
                        <dd class="text-sm text-gray-900">{{ $registration->product->warranty_period_months }} months</dd>
                    </div>
                </dl>
            </div>

            <!-- Registration Info -->
            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Registration Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Customer Name</dt>
                        <dd class="text-sm text-gray-900">{{ $registration->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-sm text-gray-900">{{ $registration->customer_email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="text-sm text-gray-900">{{ $registration->customer_phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Registered Date</dt>
                        <dd class="text-sm text-gray-900">{{ $registration->created_at->format('d M Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Warranty Dates (if approved) -->
        @if($registration->status === 'approved')
        <div class="border rounded-lg p-4 mb-6 bg-blue-50">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Warranty Coverage</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                    <dd class="text-sm text-gray-900">{{ $registration->warranty_start_date->format('d M Y') ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">End Date</dt>
                    <dd class="text-sm text-gray-900">{{ $registration->warranty_end_date->format('d M Y') ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd>
                        @if(now()->lessThanOrEqualTo($registration->warranty_end_date))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                Expired
                            </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
        @endif

        <!-- Action -->
        <div class="flex gap-3">
            <a href="{{ route('warranty.check') }}" class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition duration-150">
                Check Another
            </a>
            <a href="{{ route('warranty.register') }}" class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-150">
                Register New Product
            </a>
        </div>
    </div>
</x-guest-layout>