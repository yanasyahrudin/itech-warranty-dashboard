<!-- filepath: resources/views/admin/qr-code/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Code Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Warranty QR Code Universal</h3>
                    
                    <!-- Info Box -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-blue-800">QR Code Universal</p>
                                <p class="text-xs text-blue-700 mt-1">
                                    Satu QR Code untuk semua produk. QR Code ini dapat dicetak dan ditempel di semua produk Anda. 
                                    Ketika user memindai kode ini, mereka akan diarahkan ke halaman registrasi garansi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code Preview -->
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Preview QR Code</h4>
                        <div class="bg-gray-50 p-8 rounded-lg border border-gray-200 flex justify-center">
                            <div class="text-center">
                                <img id="qrPreview" src="{{ route('admin.qr-code.preview') }}" alt="QR Code Preview" class="h-64 w-64">
                                <p class="text-xs text-gray-500 mt-3">Link: {{ route('warranty.register') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Download Options -->
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Download QR Code</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Download PNG -->
                            <a href="{{ route('admin.qr-code.download-png') }}" 
                                class="flex items-center justify-center p-4 bg-indigo-50 border-2 border-indigo-200 rounded-lg hover:bg-indigo-100 transition">
                                <div class="text-center">
                                    <svg class="h-8 w-8 text-indigo-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <p class="text-sm font-semibold text-indigo-900">Download as PNG</p>
                                    <p class="text-xs text-indigo-700 mt-1">Format: 300x300 pixels</p>
                                </div>
                            </a>

                            <!-- Download SVG -->
                            <a href="{{ route('admin.qr-code.download-svg') }}" 
                                class="flex items-center justify-center p-4 bg-green-50 border-2 border-green-200 rounded-lg hover:bg-green-100 transition">
                                <div class="text-center">
                                    <svg class="h-8 w-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <p class="text-sm font-semibold text-green-900">Download as SVG</p>
                                    <p class="text-xs text-green-700 mt-1">Scalable Vector (Printable)</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h4 class="text-sm font-semibold text-yellow-800 mb-2">📋 Petunjuk Penggunaan</h4>
                        <ol class="text-sm text-yellow-700 space-y-1 list-decimal list-inside">
                            <li>Download QR Code dalam format PNG atau SVG</li>
                            <li>Cetak QR Code dengan ukuran minimal 5x5 cm untuk hasil scanning optimal</li>
                            <li>Tempel QR Code di tempat yang mudah diakses pada semua produk</li>
                            <li>User dapat memindai QR Code dengan smartphone untuk registrasi garansi</li>
                            <li>Satu QR Code berlaku untuk SEMUA produk (Universal)</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>