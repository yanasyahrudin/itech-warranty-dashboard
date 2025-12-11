<!-- filepath: resources/views/admin/warehouse/issued/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Produk Dikeluarkan') }}
            </h2>
            <a href="{{ route('admin.warehouse.issued.index') }}" 
                class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Form Produk Dikeluarkan</h3>

                    <!-- Info Box -->
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-red-800">Peringatan:</p>
                                <p class="text-xs text-red-700 mt-1">
                                    Produk yang dikeluarkan akan mengurangi jumlah stok. Pastikan untuk memverifikasi jumlah sebelum pengiriman.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.warehouse.issued.store') }}" id="issueForm">
                        @csrf

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Produk <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id" id="product_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('product_id') border-red-500 @enderror" 
                                required onchange="updateProductInfo()">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-part-number="{{ $product->part_number }}"
                                        data-name="{{ $product->name }}"
                                        data-type="{{ $product->type }}"
                                        data-current-stock="{{ $product->stock_quantity }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->part_number }} - {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Info Display -->
                        <div id="productInfo" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200 hidden">
                            <h4 class="font-semibold text-gray-900 mb-3 text-sm">Product Information</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-600 font-medium text-xs">Part Number</p>
                                    <p id="info-part-number" class="text-gray-900 font-semibold text-sm">-</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 font-medium text-xs">Product Name</p>
                                    <p id="info-name" class="text-gray-900 font-semibold text-sm">-</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 font-medium text-xs">Product Type</p>
                                    <p id="info-type" class="text-gray-900 text-sm">-</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 font-medium text-xs">Available Stock</p>
                                    <p id="info-current-stock" class="text-gray-900 font-bold text-sm">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah yang Dikeluarkan <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('quantity') border-red-500 @enderror" 
                                placeholder="Masukkan jumlah yang dikeluarkan"
                                required
                                onkeyup="calculateNewStock()">
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Masukkan jumlah unit yang dikeluarkan</p>
                        </div>

                        <!-- Stock Preview -->
                        <div id="stockPreview" class="mb-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200 hidden">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-yellow-900">Pratinjau Pembaruan Stok</p>
                                    <p class="text-xs text-yellow-700 mt-1">
                                        Saat Ini: <strong><span id="preview-current">0</span></strong> unit → 
                                        Baru: <strong><span id="preview-new">0</span></strong> unit
                                        (<span class="text-red-600">-<span id="preview-removed">0</span></span>)
                                    </p>
                                </div>
                                <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Destination -->
                        <div class="mb-6">
                            <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">
                                Tujuan / Penerima <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="destination" id="destination" value="{{ old('destination') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('destination') border-red-500 @enderror" 
                                placeholder="e.g., Nama Pelanggan, Departemen, Proyek"
                                required>
                            @error('destination')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Ke mana produk ini akan dikirim?</p>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('notes') border-red-500 @enderror"
                                placeholder="Catatan tambahan tentang pengeluaran ini...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Contoh: Nomor pesanan, alamat pengiriman, instruksi khusus</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.warehouse.issued.index') }}" 
                                class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                                Batal
                            </a>
                            <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                                Keluarkan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateProductInfo() {
            const select = document.getElementById('product_id');
            const selectedOption = select.options[select.selectedIndex];
            const productInfo = document.getElementById('productInfo');
            
            if (selectedOption.value) {
                const partNumber = selectedOption.dataset.partNumber;
                const name = selectedOption.dataset.name;
                const type = selectedOption.dataset.type;
                const currentStock = selectedOption.dataset.currentStock;

                document.getElementById('info-part-number').textContent = partNumber;
                document.getElementById('info-name').textContent = name;
                document.getElementById('info-type').textContent = type;
                document.getElementById('info-current-stock').textContent = parseInt(currentStock).toLocaleString() + ' units';
                
                // Set max quantity
                document.getElementById('quantity').max = currentStock;
                
                productInfo.classList.remove('hidden');
                
                // Calculate if quantity is already filled
                calculateNewStock();
            } else {
                productInfo.classList.add('hidden');
                document.getElementById('stockPreview').classList.add('hidden');
            }
        }

        function calculateNewStock() {
            const select = document.getElementById('product_id');
            const selectedOption = select.options[select.selectedIndex];
            const quantityInput = document.getElementById('quantity');
            const stockPreview = document.getElementById('stockPreview');

            if (selectedOption.value && quantityInput.value && parseInt(quantityInput.value) > 0) {
                const currentStock = parseInt(selectedOption.dataset.currentStock);
                const quantityIssued = parseInt(quantityInput.value);
                const newStock = currentStock - quantityIssued;

                // Check if quantity exceeds stock
                if (quantityIssued > currentStock) {
                    stockPreview.classList.remove('bg-yellow-50', 'border-yellow-200');
                    stockPreview.classList.add('bg-red-100', 'border-red-300');
                    stockPreview.querySelector('.text-yellow-900').classList.remove('text-yellow-900');
                    stockPreview.querySelector('.text-yellow-700').classList.remove('text-yellow-700');
                    stockPreview.querySelector('p').classList.add('text-red-900');
                    stockPreview.querySelector('p + p').classList.add('text-red-800');
                } else {
                    stockPreview.classList.remove('bg-red-100', 'border-red-300');
                    stockPreview.classList.add('bg-yellow-50', 'border-yellow-200');
                }

                document.getElementById('preview-current').textContent = currentStock.toLocaleString();
                document.getElementById('preview-new').textContent = Math.max(0, newStock).toLocaleString();
                document.getElementById('preview-removed').textContent = quantityIssued.toLocaleString();

                stockPreview.classList.remove('hidden');
            } else {
                stockPreview.classList.add('hidden');
            }
        }

        // Initialize if product is pre-selected
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('product_id').value) {
                updateProductInfo();
            }
        });
    </script>
</x-app-layout>