<!-- filepath: resources/views/admin/qr-code/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('Manajemen QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Universal QR Code Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">🔗 Universal QR Code untuk Registrasi Garansi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- QR Code Preview -->
                        <div class="border-2 border-gray-300 rounded-xl p-6 text-center bg-gray-50">
                            <h4 class="font-semibold text-gray-700 mb-4">Pratinjau QR Code</h4>
                            
                            <!-- QR Code Image -->
                            <div class="flex justify-center mb-4">
                                <img src="{{ route('admin.qr-code.preview', ['size' => 200]) }}" 
                                     alt="QR Code" 
                                     class="border-4 border-white shadow-lg rounded"
                                     id="qrCodePreview">
                            </div>
                            
                            <!-- Size Selector -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran QR Code</label>
                                <select id="qrSize" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500"
                                    onchange="updateQrPreview()">
                                    <option value="150">Kecil (150x150 px)</option>
                                    <option value="200" selected>Sedang (200x200 px)</option>
                                    <option value="300">Besar (300x300 px)</option>
                                    <option value="500">Ekstra Besar (500x500 px)</option>
                                </select>
                            </div>
                            
                            <!-- QR Code Info -->
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded text-left">
                                <p class="text-xs text-blue-800">
                                    <strong>URL Tujuan:</strong><br>
                                    <code class="bg-blue-100 px-2 py-1 rounded text-xs">{{ $registrationUrl }}</code>
                                </p>
                            </div>
                        </div>

                        <!-- Download Options -->
                        <div class="border-2 border-gray-300 rounded-xl p-6 bg-gray-50">
                            <h4 class="font-semibold text-gray-700 mb-4">Opsi Unduhan</h4>
                            
                            <!-- Format Selection -->
                            <div class="space-y-4">
                                <!-- PNG Format -->
                                <div class="p-4 bg-white border border-gray-200 rounded-xl">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">Format PNG</p>
                                            <p class="text-xs text-gray-600">Terbaik untuk cetak dan penggunaan digital</p>
                                        </div>
                                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <a href="{{ route('admin.qr-code.download', ['format' => 'png', 'size' => 300]) }}" 
                                       class="inline-block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition">
                                        Unduh PNG
                                    </a>
                                </div>

                                <!-- SVG Format -->
                                <div class="p-4 bg-white border border-gray-200 rounded-xl">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">Format SVG</p>
                                            <p class="text-xs text-gray-600">Format vektor yang dapat diskalakan</p>
                                        </div>
                                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <a href="{{ route('admin.qr-code.download', ['format' => 'svg', 'size' => 300]) }}" 
                                       class="inline-block w-full text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition">
                                        Unduh SVG
                                    </a>
                                </div>

                                <!-- PDF Format -->
                                <div class="p-4 bg-white border border-gray-200 rounded-xl">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900">Format PDF</p>
                                            <p class="text-xs text-gray-600">Dokumen siap cetak</p>
                                        </div>
                                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <a href="{{ route('admin.qr-code.download', ['format' => 'pdf', 'size' => 300]) }}" 
                                       class="inline-block w-full text-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition">
                                        Unduh PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Instructions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">📋 Petunjuk Penggunaan</h3>
                    
                    <div class="space-y-4">
                        <div class="p-4 bg-blue-50 border-l-4 border-blue-500">
                            <h4 class="font-semibold text-blue-900 mb-2">🎯 Tujuan</h4>
                            <p class="text-sm text-blue-800">
                                QR ini adalah <strong>universal</strong> dan dapat digunakan untuk SEMUA produk. 
                                Saat dipindai, QR ini mengarahkan pelanggan ke formulir registrasi garansi.
                            </p>
                        </div>

                        <div class="p-4 bg-green-50 border-l-4 border-green-500">
                            <h4 class="font-semibold text-green-900 mb-2">✅ Cara Menggunakan</h4>
                            <ul class="list-disc list-inside text-sm text-green-800 space-y-1">
                                <li>Unduh kode QR dalam format pilihan Anda</li>
                                <li>Cetak pada label produk, kemasan, atau kartu garansi</li>
                                <li>Pelanggan memindai kode QR dengan ponsel mereka</li>
                                <li>Mereka diarahkan ke formulir registrasi garansi</li>
                                <li>Pelanggan mengisi detail produk dan mengirimkan</li>
                            </ul>
                        </div>

                        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500">
                            <h4 class="font-semibold text-yellow-900 mb-2">💡 Tips</h4>
                            <ul class="list-disc list-inside text-sm text-yellow-800 space-y-1">
                                <li>Gunakan format PNG untuk pencetakan berkualitas tinggi</li>
                                <li>Ukuran minimum: 2cm x 2cm untuk pemindaian mudah</li>
                                <li>Uji kode QR sebelum pencetakan massal</li>
                                <li>Tempatkan kode QR di lokasi yang terlihat pada produk</li>
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