

    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-500 leading-tight">
                    {{ __('Manajemen Produk') }}
                </h2>
                <a href="{{ route('admin.products.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl transition duration-150">
                    Tambah Produk Baru
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <!-- Total Products -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6 bg-white ">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-500">Total Produk</p>
                                    <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ number_format($stats['total_products']) }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <svg class="h-12 w-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Stock -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6 bg-white ">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-500">Total Stok</p>
                                    <p class="mt-1 text-3xl font-semibold text-green-600">{{ number_format($stats['total_stock']) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Units</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6 bg-white ">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-500">Peringatan Stok Rendah</p>
                                    <p class="mt-1 text-3xl font-semibold text-yellow-600">{{ number_format($stats['low_stock']) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">≤ 10 unit</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <svg class="h-12 w-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Types -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                        <div class="p-6 bg-white ">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-500">Tipe Produk</p>
                                    <p class="mt-1 text-3xl font-semibold text-blue-600">{{ number_format($stats['product_types']) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Kategori</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <svg class="h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-50  rounded-xl">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 p-4 bg-red-50  rounded-xl">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                <!-- Products Table -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Produk</h3>

                        @if($products->count())
                        <div class="overflow-x-auto ">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Garansi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($products as $product)
                                    <tr class="hover:bg-gray-50 transition">
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
                                            <div class="text-sm {{ $product->stock_quantity <= 10 ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                                                {{ number_format($product->stock_quantity) }}
                                                @if($product->stock_quantity <= 10)
                                                    <span class="text-xs">⚠️</span>
                                                    @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $product->warranty_period_months }} bulan</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex space-x-2 gap-2">
                                                <a href="{{ route('admin.products.show', $product) }}"
                                                    class="text-blue-600 hover:text-blue-900 font-medium">
                                                    Lihat
                                                </a>
                                                <span class="text-gray-300">|</span>
                                                <a href="{{ route('admin.products.edit', $product) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                    Edit
                                                </a>
                                                <span class="text-gray-300">|</span>
                                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this product?');"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                                        Hapus
                                                    </button>
                                                </form>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p class="text-sm text-gray-500 mb-4">Tidak ada produk ditemukan</p>
                            <a href="{{ route('admin.products.create') }}"
                                class="inline-block text-indigo-600 hover:text-indigo-900 font-medium">
                                Tambah produk pertama Anda →
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
