<!-- filepath: resources/views/admin/labels/generate.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Label Preview') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.labels.index') }}" 
                    class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                    ← Back to List
                </a>
                <a href="{{ route('admin.labels.download', $product) }}" 
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                    📥 Download PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Label Preview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-8 bg-white">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 text-center">Label Preview (10cm x 5cm)</h3>
                    
                    <!-- Label Container -->
                    <div class="border-2 border-gray-300 rounded-lg p-6 mx-auto" style="width: 10cm; height: 5cm;">
                        <div class="flex h-full">
                            <!-- QR Code Section -->
                            <div class="w-2/5 flex items-center justify-center border-r border-gray-200 pr-4">
                                <div class="text-center">
                                    <div class="w-32 h-32 mx-auto">
                                        {!! $qrCode !!}
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Scan for Warranty</p>
                                </div>
                            </div>
                            
                            <!-- Product Info Section -->
                            <div class="w-3/5 pl-4 flex flex-col justify-center">
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Part Number</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $product->part_number }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Product Name</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $product->name }}</p>
                                </div>
                                
                                <div class="mb-2">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Type</p>
                                    <p class="text-sm text-gray-700">{{ $product->type }}</p>
                                </div>
                                
                                <div class="mt-auto pt-2 border-t border-gray-200">
                                    <p class="text-xs text-gray-600">
                                        <span class="font-semibold">Warranty:</span> {{ $product->warranty_period_months }} months
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Info (Below Label) -->
                    <div class="text-center mt-6 text-xs text-gray-500">
                        <p class="font-semibold">iTech Warranty System</p>
                        <p>{{ $qrCodeUrl }}</p>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-semibold text-blue-900 mb-2">How to Use:</h4>
                <ol class="text-sm text-blue-800 space-y-1 list-decimal list-inside">
                    <li>Print this label on adhesive paper (10cm x 5cm recommended)</li>
                    <li>Attach the label to the product unit</li>
                    <li>Customer scans the QR code to register warranty</li>
                    <li>All products use the same QR code (Universal)</li>
                </ol>
            </div>

        </div>
    </div>
</x-app-layout>