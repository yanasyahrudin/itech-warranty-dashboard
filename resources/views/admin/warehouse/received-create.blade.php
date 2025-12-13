<!-- filepath: resources/views/admin/warehouse/received-create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Product Received
            </h2>
            <a href="{{ route('admin.warehouse.received.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <h3 class="text-sm font-semibold text-red-800 mb-2">Errors:</h3>
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Info Alert -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Note:</strong> Serial numbers will be automatically generated based on the quantity you enter. 
                            You will be able to print them after submission.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Receive Product Form</h3>

                    <form action="{{ route('admin.warehouse.received.store') }}" method="POST">
                        @csrf

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Product <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id" 
                                    id="product_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500"
                                    required
                                    onchange="showProductInfo()">
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-name="{{ $product->name }}"
                                            data-part="{{ $product->part_number }}"
                                            data-type="{{ $product->type }}"
                                            data-stock="{{ $product->stock_quantity }}"
                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->part_number }} - {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <!-- Product Info -->
                            <div id="productInfo" class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded hidden">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">Part Number:</span>
                                        <span class="font-semibold text-gray-900" id="infoPartNumber">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Type:</span>
                                        <span class="font-semibold text-gray-900" id="infoType">-</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Current Stock:</span>
                                        <span class="font-semibold text-gray-900" id="infoStock">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="quantity" 
                                   id="quantity" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500"
                                   placeholder="Enter quantity"
                                   value="{{ old('quantity', 1) }}"
                                   min="1"
                                   max="1000"
                                   required
                                   onchange="updateSerialPreview()">
                            <p class="mt-1 text-xs text-gray-500">Number of units received (1-1000)</p>
                            
                            <!-- Serial Number Preview -->
                            <div id="serialPreview" class="mt-2 p-3 bg-green-50 border border-green-200 rounded hidden">
                                <p class="text-sm text-green-800">
                                    <strong>Will generate:</strong> <span id="serialCount">0</span> unique serial numbers
                                </p>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notes (Optional)
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500"
                                      placeholder="Supplier name, purchase order number, etc...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.warehouse.received.index') }}" 
                               class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-xl transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition">
                                📥 Receive & Generate Serials
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function showProductInfo() {
            const select = document.getElementById('product_id');
            const productInfo = document.getElementById('productInfo');
            
            if (select.value) {
                const option = select.options[select.selectedIndex];
                document.getElementById('infoPartNumber').textContent = option.dataset.part;
                document.getElementById('infoType').textContent = option.dataset.type;
                document.getElementById('infoStock').textContent = option.dataset.stock + ' units';
                productInfo.classList.remove('hidden');
                
                updateSerialPreview();
            } else {
                productInfo.classList.add('hidden');
            }
        }

        function updateSerialPreview() {
            const quantity = document.getElementById('quantity').value;
            const serialPreview = document.getElementById('serialPreview');
            const serialCount = document.getElementById('serialCount');
            
            if (quantity > 0) {
                serialCount.textContent = quantity;
                serialPreview.classList.remove('hidden');
            } else {
                serialPreview.classList.add('hidden');
            }
        }

        // Auto-update on page load
        document.addEventListener('DOMContentLoaded', function() {
            showProductInfo();
        });
    </script>
</x-app-layout>