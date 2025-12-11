<!-- filepath: resources/views/admin/warehouse/received/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Receive Products') }}
            </h2>
            <a href="{{ route('admin.warehouse.received.index') }}" 
                class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Product Receipt Form</h3>

                    <!-- Info Box -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-blue-800">Note:</p>
                                <p class="text-xs text-blue-700 mt-1">
                                    Receiving products will automatically update the stock quantity in the system.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.warehouse.received.store') }}" id="receiveForm">
                        @csrf

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Product <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id" id="product_id" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('product_id') border-red-500 @enderror" 
                                required onchange="updateProductInfo()">
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-part-number="{{ $product->part_number }}"
                                        data-name="{{ $product->name }}"
                                        data-type="{{ $product->type }}"
                                        data-current-stock="{{ $product->stock_quantity }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->part_number }} - {{ $product->name }} ({{ $product->type }})
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
                                    <p class="text-gray-600 font-medium text-xs">Current Stock</p>
                                    <p id="info-current-stock" class="text-gray-900 font-bold text-sm">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity Received <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" max="10000"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('quantity') border-red-500 @enderror" 
                                placeholder="Enter quantity received"
                                required
                                onkeyup="calculateNewStock()">
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Enter the number of units received</p>
                        </div>

                        <!-- Stock Preview -->
                        <div id="stockPreview" class="mb-6 p-4 bg-green-50 rounded-lg border border-green-200 hidden">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-900">Stock Update Preview</p>
                                    <p class="text-xs text-green-700 mt-1">
                                        Current: <strong><span id="preview-current">0</span></strong> units → 
                                        New: <strong><span id="preview-new">0</span></strong> units
                                        (<span class="text-green-600">+<span id="preview-added">0</span></span>)
                                    </p>
                                </div>
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notes (Optional)
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('notes') border-red-500 @enderror"
                                placeholder="Additional notes about this receipt...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Example: Delivery batch number, supplier info, condition notes</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.warehouse.received.index') }}" 
                                class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                                📦 Receive Products
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
                const quantityReceived = parseInt(quantityInput.value);
                const newStock = currentStock + quantityReceived;

                document.getElementById('preview-current').textContent = currentStock.toLocaleString();
                document.getElementById('preview-new').textContent = newStock.toLocaleString();
                document.getElementById('preview-added').textContent = quantityReceived.toLocaleString();

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