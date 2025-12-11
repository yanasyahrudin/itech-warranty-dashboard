<!-- filepath: resources/views/admin/labels/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Generator Label Produk') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Info Card -->
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Sistem QR Code Universal</h3>
                        <p class="text-sm text-blue-800 mb-2">
                            Semua produk menggunakan <strong>kode QR yang sama</strong> yang terhubung ke formulir registrasi garansi.
                        </p>
                        <div class="bg-white rounded p-3 mt-3 border border-blue-200">
                            <p class="text-xs text-gray-600 mb-1">URL QR Code Universal:</p>
                            <code class="text-sm text-blue-700 font-mono">{{ route('warranty.register') }}</code>
                        </div>
                        <p class="text-xs text-blue-700 mt-3">
                            📦 Setiap label mencakup: QR Code + Detail Produk (Nama, Nomor Part, Tipe)
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bulk Generate Card -->
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🏷️ Generator Label Massal</h3>
                    <p class="text-sm text-gray-600 mb-4">Pilih beberapa produk dan buat label secara massal</p>
                    
                    <form method="POST" action="{{ route('admin.labels.bulk-generate') }}" id="bulkForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah per Produk
                                </label>
                                <input type="number" name="quantity" value="10" min="1" max="100"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <p class="text-xs text-gray-500 mt-1">Jumlah label yang akan dibuat untuk setiap produk yang dipilih</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <span id="selectedCount">0</span> produk dipilih
                            </div>
                            <button type="submit" id="bulkGenerateBtn" disabled
                                class="bg-indigo-600 hover:bg-indigo-700 text-gray-600 font-bold py-2 px-4 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed transition duration-150">
                                📄 Buat PDF Massal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Produk</h3>

                    @if($products->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left">
                                            <input type="checkbox" id="selectAll" 
                                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                onchange="toggleSelectAll(this)">
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Garansi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($products as $product)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" 
                                                    class="product-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    onchange="updateSelectedCount()">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">{{ $product->part_number }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $product->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $product->type }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ number_format($product->stock_quantity) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $product->warranty_period_months }} bulan</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex space-x-2 gap-2">
                                                    <a href="{{ route('admin.labels.generate', $product) }}" 
                                                        class="text-indigo-600 hover:text-indigo-900 font-medium"
                                                        title="Preview Label">
                                                        Lihat
                                                    </a>
                                                    <span class="text-gray-300">|</span>
                                                    <a href="{{ route('admin.labels.download', $product) }}" 
                                                        class="text-green-600 hover:text-green-900 font-medium"
                                                        title="Download PDF">
                                                        PDF
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-sm text-gray-500">No products found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSelectAll(checkbox) {
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            productCheckboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
            const count = checkedBoxes.length;
            document.getElementById('selectedCount').textContent = count;
            
            const bulkBtn = document.getElementById('bulkGenerateBtn');
            bulkBtn.disabled = count === 0;
            
            // Add checked IDs to bulk form
            const bulkForm = document.getElementById('bulkForm');
            
            // Remove existing hidden inputs
            bulkForm.querySelectorAll('input[name="product_ids[]"]').forEach(input => input.remove());
            
            // Add new hidden inputs
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'product_ids[]';
                input.value = checkbox.value;
                bulkForm.appendChild(input);
            });
        }
    </script>
</x-app-layout>