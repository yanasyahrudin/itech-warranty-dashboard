<!-- filepath: resources/views/admin/warehouse/issued-create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Product Issued
            </h2>
            <a href="{{ route('admin.warehouse.issued.index') }}" 
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Issue Product Form</h3>

                    <form action="{{ route('admin.warehouse.issued.store') }}" method="POST">
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
                                    onchange="updateStockInfo()">
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-stock="{{ $product->stock_quantity }}"
                                            data-name="{{ $product->name }}"
                                            data-part="{{ $product->part_number }}"
                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->part_number }} - {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                            
                            <!-- Stock Info Alert -->
                            <div id="stockInfo" class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded hidden">
                                <p class="text-sm text-blue-800">
                                    <strong>Available Stock:</strong> <span id="stockQuantity">0</span> units
                                </p>
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
                                   value="{{ old('quantity') }}"
                                   min="1"
                                   required>
                            <p class="mt-1 text-xs text-gray-500">Number of units to issue</p>
                        </div>

                        <!-- Destination -->
                        <div class="mb-6">
                            <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">
                                Destination <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="destination" 
                                   id="destination" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500"
                                   placeholder="e.g., Store Jakarta, Customer XYZ, Production Line"
                                   value="{{ old('destination') }}"
                                   required>
                            <p class="mt-1 text-xs text-gray-500">Where the products will be sent</p>
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
                                      placeholder="Additional information...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.warehouse.issued.index') }}" 
                               class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-xl transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition">
                                Issue Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function updateStockInfo() {
            const select = document.getElementById('product_id');
            const stockInfo = document.getElementById('stockInfo');
            const stockQuantity = document.getElementById('stockQuantity');
            const quantityInput = document.getElementById('quantity');
            
            if (select.value) {
                const option = select.options[select.selectedIndex];
                const stock = option.dataset.stock;
                
                stockQuantity.textContent = stock;
                stockInfo.classList.remove('hidden');
                
                // Set max quantity
                quantityInput.max = stock;
                
                // Warning if low stock
                if (parseInt(stock) < 10) {
                    stockInfo.classList.remove('bg-blue-50', 'border-blue-200');
                    stockInfo.classList.add('bg-yellow-50', 'border-yellow-200');
                    stockInfo.querySelector('p').classList.remove('text-blue-800');
                    stockInfo.querySelector('p').classList.add('text-yellow-800');
                }
            } else {
                stockInfo.classList.add('hidden');
            }
        }

        // Auto-update on page load if product is selected
        document.addEventListener('DOMContentLoaded', function() {
            updateStockInfo();
        });
    </script>
</x-app-layout>