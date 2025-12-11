<!-- filepath: resources/views/admin/products/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Product') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" 
                class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Product Information</h3>

                    <!-- Info Box -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-blue-800">Universal QR Code System</p>
                                <p class="text-xs text-blue-700 mt-1">
                                    All products use the same universal QR code. Customers select the product during warranty registration.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.products.store') }}" id="productForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Part Number -->
                            <div class="md:col-span-2">
                                <label for="part_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Part Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="part_number" id="part_number" value="{{ old('part_number') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 uppercase @error('part_number') border-red-500 @enderror" 
                                    placeholder="e.g., CPU-INTEL-I7-001"
                                    required
                                    style="text-transform: uppercase;">
                                @error('part_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Unique identifier for the product (will be auto-converted to uppercase)</p>
                            </div>

                            <!-- Product Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Product Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror" 
                                    placeholder="e.g., Intel Core i7-12700K Processor"
                                    required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Full product name</p>
                            </div>

                            <!-- Product Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Product Type <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="type" id="type" value="{{ old('type') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('type') border-red-500 @enderror" 
                                    placeholder="e.g., Processor, Motherboard, RAM"
                                    list="typesList"
                                    required>
                                <datalist id="typesList">
                                    @foreach($productTypes as $type)
                                        <option value="{{ $type }}">
                                    @endforeach
                                    <option value="Processor">
                                    <option value="Motherboard">
                                    <option value="RAM">
                                    <option value="Graphics Card">
                                    <option value="Storage">
                                    <option value="Power Supply">
                                    <option value="Case">
                                    <option value="Cooling">
                                </datalist>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Category of the product</p>
                            </div>

                            <!-- Warranty Period -->
                            <div>
                                <label for="warranty_period_months" class="block text-sm font-medium text-gray-700 mb-2">
                                    Warranty Period (Months) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="warranty_period_months" id="warranty_period_months" 
                                    value="{{ old('warranty_period_months', 12) }}" min="1" max="120"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('warranty_period_months') border-red-500 @enderror" 
                                    required>
                                @error('warranty_period_months')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Number of months warranty coverage</p>
                            </div>

                            <!-- Initial Stock -->
                            <div class="md:col-span-2">
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                    Initial Stock Quantity
                                </label>
                                <input type="number" name="stock_quantity" id="stock_quantity" 
                                    value="{{ old('stock_quantity', 0) }}" min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('stock_quantity') border-red-500 @enderror">
                                @error('stock_quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Optional: Initial stock quantity (can be updated later via Warehouse menu)</p>
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description (Optional)
                                </label>
                                <textarea name="description" id="description" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror"
                                    placeholder="Additional product details, specifications, or notes...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Optional product description or notes</p>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-200">
                            <a href="{{ route('admin.products.index') }}" 
                                class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                                ➕ Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-2 text-sm">💡 Quick Tips:</h4>
                <ul class="text-xs text-gray-700 space-y-1 list-disc list-inside">
                    <li>Part Number must be unique and will be auto-converted to uppercase</li>
                    <li>Warranty period is in months (e.g., 12 months = 1 year)</li>
                    <li>Initial stock can be set to 0 and updated later via Warehouse menu</li>
                    <li>All products will use the same universal QR code for warranty registration</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Auto uppercase part number
        document.getElementById('part_number').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    </script>
</x-app-layout>