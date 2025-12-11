<!-- filepath: resources/views/admin/qr-code/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Code Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Universal QR Code Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">🔗 Universal QR Code for Warranty Registration</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- QR Code Preview -->
                        <div class="border-2 border-gray-300 rounded-lg p-6 text-center bg-gray-50">
                            <h4 class="font-semibold text-gray-700 mb-4">QR Code Preview</h4>
                            
                            <!-- QR Code Image -->
                            <div class="flex justify-center mb-4">
                                <img src="{{ route('admin.qr-code.preview', ['size' => 200]) }}" 
                                     alt="QR Code" 
                                     class="border-4 border-white shadow-lg rounded"
                                     id="qrCodePreview">
                            </div>
                            
                            <!-- Size Selector -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">QR Code Size</label>
                                <select id="qrSize" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
                                    onchange="updateQrPreview()">
                                    <option value="150">Small (150x150 px)</option>
                                    <option value="200" selected>Medium (200x200 px)</option>
                                    <option value="300">Large (300x300 px)</option>
                                    <option value="500">Extra Large (500x500 px)</option>
                                </select>
                            </div>
                            
                            <!-- QR Code Info -->
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded text-left">
                                <p class="text-xs text-blue-800">
                                    <strong>Destination URL:</strong><br>
                                    <code class="bg-blue-100 px-2 py-1 rounded text-xs">{{ $registrationUrl }}</code>
                                </p>
                            </div>
                        </div>

                        <!-- Download Options -->
                        <div class="border-2 border-gray-300 rounded-lg p-6 bg-gray-50">
                            <h4 class="font-semibold text-gray-700 mb-4">📥 Download Options</h4>
                            
                            <!-- Format Selection -->
                            <div class="space-y-4">
                                <!-- PNG Format -->
                                <div class="p-4 bg-white border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">PNG Format</p>
                                            <p class="text-xs text-gray-600">Best for printing and digital use</p>
                                        </div>
                                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <a href="{{ route('admin.qr-code.download', ['format' => 'png', 'size' => 300]) }}" 
                                       class="inline-block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                        Download PNG
                                    </a>
                                </div>

                                <!-- SVG Format -->
                                <div class="p-4 bg-white border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">SVG Format</p>
                                            <p class="text-xs text-gray-600">Scalable vector format</p>
                                        </div>
                                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <a href="{{ route('admin.qr-code.download', ['format' => 'svg', 'size' => 300]) }}" 
                                       class="inline-block w-full text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                                        Download SVG
                                    </a>
                                </div>

                                <!-- PDF Format -->
                                <div class="p-4 bg-white border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">PDF Format</p>
                                            <p class="text-xs text-gray-600">Print-ready document</p>
                                        </div>
                                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <a href="{{ route('admin.qr-code.download', ['format' => 'pdf', 'size' => 300]) }}" 
                                       class="inline-block w-full text-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Instructions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">📋 Usage Instructions</h3>
                    
                    <div class="space-y-4">
                        <div class="p-4 bg-blue-50 border-l-4 border-blue-500">
                            <h4 class="font-semibold text-blue-900 mb-2">🎯 Purpose</h4>
                            <p class="text-sm text-blue-800">
                                This QR code is <strong>universal</strong> and can be used for ALL products. 
                                When scanned, it directs customers to the warranty registration form.
                            </p>
                        </div>

                        <div class="p-4 bg-green-50 border-l-4 border-green-500">
                            <h4 class="font-semibold text-green-900 mb-2">✅ How to Use</h4>
                            <ul class="list-disc list-inside text-sm text-green-800 space-y-1">
                                <li>Download the QR code in your preferred format</li>
                                <li>Print it on product labels, packaging, or warranty cards</li>
                                <li>Customers scan the QR code with their phone</li>
                                <li>They are directed to the warranty registration form</li>
                                <li>Customer fills in product details and submits</li>
                            </ul>
                        </div>

                        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500">
                            <h4 class="font-semibold text-yellow-900 mb-2">💡 Tips</h4>
                            <ul class="list-disc list-inside text-sm text-yellow-800 space-y-1">
                                <li>Use PNG format for high-quality printing</li>
                                <li>Minimum size: 2cm x 2cm for easy scanning</li>
                                <li>Test QR code before mass printing</li>
                                <li>Place QR code in visible location on product</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function updateQrPreview() {
            const size = document.getElementById('qrSize').value;
            const preview = document.getElementById('qrCodePreview');
            preview.src = "{{ route('admin.qr-code.preview') }}?size=" + size;
        }
    </script>
</x-app-layout>