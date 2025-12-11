<!-- filepath: resources/views/admin/warranty/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Warranty Registration Detail') }}
            </h2>
            <a href="{{ route('admin.warranty.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alerts -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Status Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $registration->serial_number }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Serial Number</p>
                                </div>
                                <div>
                                    @if($registration->status === 'pending')
                                        <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending Review
                                        </span>
                                    @elseif($registration->status === 'approved')
                                        <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @else
                                        <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Registration Information</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Product Info -->
                                <div>
                                    <h5 class="text-sm font-semibold text-gray-700 mb-3">Product Details</h5>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 uppercase">Product Name</dt>
                                            <dd class="text-sm text-gray-900">{{ $registration->product->name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 uppercase">Part Number</dt>
                                            <dd class="text-sm text-gray-900">{{ $registration->product->part_number }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 uppercase">Product Type</dt>
                                            <dd class="text-sm text-gray-900">{{ $registration->product->type }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 uppercase">Warranty Period</dt>
                                            <dd class="text-sm text-gray-900">{{ $registration->product->warranty_period_months }} months</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Customer Info -->
                                <div>
                                    <h5 class="text-sm font-semibold text-gray-700 mb-3">Customer Details</h5>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 uppercase">Customer Name</dt>
                                            <dd class="text-sm text-gray-900">{{ $registration->customer_name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                                            <dd class="text-sm text-gray-900">
                                                <a href="mailto:{{ $registration->customer_email }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $registration->customer_email }}
                                                </a>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                                            <dd class="text-sm text-gray-900">
                                                <a href="tel:{{ $registration->customer_phone }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $registration->customer_phone }}
                                                </a>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 uppercase">Registration Date</dt>
                                            <dd class="text-sm text-gray-900">{{ $registration->created_at->format('d M Y H:i') }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            @if($registration->additional_info)
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Additional Information</h5>
                                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $registration->additional_info }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Invoice Preview -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Invoice Document</h4>
                            
                            @if($registration->invoice_path)
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    @if(str_ends_with($registration->invoice_path, '.pdf'))
                                        <div class="text-center py-8">
                                            <svg class="h-16 w-16 text-red-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            <p class="text-sm font-semibold text-gray-900">{{ basename($registration->invoice_path) }}</p>
                                            <p class="text-xs text-gray-500 mt-2">PDF Document</p>
                                            <a href="{{ asset('storage/' . $registration->invoice_path) }}" 
                                                target="_blank" 
                                                class="mt-3 inline-block text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                📥 Download PDF
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $registration->invoice_path) }}" 
                                                alt="Invoice" 
                                                class="max-h-96 mx-auto rounded border border-gray-200">
                                            <a href="{{ asset('storage/' . $registration->invoice_path) }}" 
                                                target="_blank" 
                                                class="mt-3 inline-block text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                🔍 View Full Size
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No invoice uploaded</p>
                            @endif
                        </div>
                    </div>

                    <!-- Warranty Dates (if approved) -->
                    @if($registration->status === 'approved')
                        <div class="bg-blue-50 border-2 border-blue-200 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-blue-900 mb-4">Warranty Coverage</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-white p-4 rounded-lg border border-blue-200">
                                        <dt class="text-xs font-medium text-blue-600 uppercase">Start Date</dt>
                                        <dd class="text-xl font-semibold text-blue-900 mt-1">
                                            {{ $registration->warranty_start_date->format('d M Y') }}
                                        </dd>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-blue-200">
                                        <dt class="text-xs font-medium text-blue-600 uppercase">End Date</dt>
                                        <dd class="text-xl font-semibold text-blue-900 mt-1">
                                            {{ $registration->warranty_end_date->format('d M Y') }}
                                        </dd>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-blue-200">
                                        <dt class="text-xs font-medium text-blue-600 uppercase">Status</dt>
                                        <dd class="text-xl font-semibold mt-1">
                                            @if(now()->lessThanOrEqualTo($registration->warranty_end_date))
                                                <span class="text-green-600">✓ Active</span>
                                            @else
                                                <span class="text-gray-600">✗ Expired</span>
                                            @endif
                                        </dd>
                                    </div>
                                </div>

                                <div class="mt-4 text-sm text-blue-700">
                                    <p>Approved by: <strong>{{ $registration->approvedByUser->name ?? 'System' }}</strong> on {{ $registration->approved_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Rejection Info (if rejected) -->
                    @if($registration->status === 'rejected')
                        <div class="bg-red-50 border-2 border-red-200 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-red-900 mb-4">Rejection Details</h4>
                                
                                <div class="mb-4 p-4 bg-white rounded-lg border border-red-200">
                                    <p class="text-sm text-red-900 whitespace-pre-wrap">{{ $registration->rejection_reason }}</p>
                                </div>

                                <div class="text-sm text-red-700">
                                    <p>Rejected by: <strong>{{ $registration->rejectedByUser->name ?? 'System' }}</strong> on {{ $registration->rejected_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($registration->status === 'rejected' && $registration->rejection_reason)
                        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <h4 class="font-semibold text-red-900 mb-2">Rejection Reason:</h4>
                            <p class="text-sm text-red-800">{{ $registration->rejection_reason }}</p>
                            <p class="text-xs text-red-600 mt-2">
                                Rejected by: {{ $registration->verifier->name ?? 'System' }} | 
                                {{ ($registration->verified_at ?? $registration->rejected_at)?->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endif

                    @if($registration->status === 'approved')
                        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h4 class="font-semibold text-green-900 mb-2">✅ Warranty Information</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-green-700 font-medium">Warranty Start:</p>
                                    <p class="text-green-900 font-semibold">{{ $registration->warranty_start_date->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-green-700 font-medium">Warranty End:</p>
                                    <p class="text-green-900 font-semibold">{{ $registration->warranty_end_date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-green-600 mt-2">
                                Verified by: {{ $registration->verifier->name ?? 'System' }} | 
                                {{ ($registration->verified_at ?? $registration->approved_at)?->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar - Actions -->
                <div class="lg:col-span-1">
                    @if($registration->status === 'pending')
                        <!-- Approve Form -->
                        <div class="bg-green-50 border-2 border-green-200 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-green-900 mb-4">Approve Registration</h4>
                                
                                <form action="{{ route('admin.warranty.approve', $registration) }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-green-700 mb-3">
                                            ✓ Warranty period: <strong>{{ $registration->product->warranty_period_months }} months</strong>
                                        </p>
                                        <p class="text-xs text-green-600">
                                            Auto-calculated start & end dates will be set upon approval.
                                        </p>
                                    </div>

                                    <button type="submit" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                                        ✓ Approve Warranty
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Reject Form -->
                        <div class="bg-red-50 border-2 border-red-200 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-red-900 mb-4">Reject Registration</h4>
                                
                                <form action="{{ route('admin.warranty.reject', $registration) }}" method="POST" id="rejectForm">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label for="rejection_reason" class="block text-sm font-medium text-red-700 mb-2">Reason for Rejection</label>
                                        <textarea name="rejection_reason" id="rejection_reason" rows="4"
                                            class="w-full rounded-md border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500 @error('rejection_reason') border-red-500 @enderror text-sm"
                                            placeholder="Explain why this registration is rejected..."
                                            required>{{ old('rejection_reason') }}</textarea>
                                        @error('rejection_reason')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="button" 
                                        onclick="if(confirm('Are you sure you want to reject this registration?')) { document.getElementById('rejectForm').submit(); }"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                                        ✗ Reject Warranty
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Already Processed -->
                        <div class="bg-gray-50 border-2 border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">Status</h4>
                                
                                @if($registration->status === 'approved')
                                    <div class="p-3 bg-green-100 border border-green-300 rounded-lg mb-4">
                                        <p class="text-sm text-green-800">
                                            ✓ This warranty has been <strong>APPROVED</strong>
                                        </p>
                                    </div>
                                @else
                                    <div class="p-3 bg-red-100 border border-red-300 rounded-lg mb-4">
                                        <p class="text-sm text-red-800">
                                            ✗ This warranty has been <strong>REJECTED</strong>
                                        </p>
                                    </div>
                                @endif

                                <p class="text-xs text-gray-600 text-center">
                                    This registration cannot be modified.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>