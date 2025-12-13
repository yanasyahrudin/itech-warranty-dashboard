<!-- filepath: resources/views/admin/products/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-500 leading-tight">
                {{ __('Product Details') }}
            </h2>
            <a href="{{ route('admin.products.edit', $product) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Edit Product
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Product Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Produk</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">Part Number</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->part_number }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">Nama Produk</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->name }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">Tipe Produk</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->type }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">Periode Garansi</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->warranty_period_months }} bulan</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">Stok Saat Ini</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->stock_quantity }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">Total Registrasi</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->warrantyRegistrations->count() }}</p>
                        </div>
                        @if($product->description)
                        <div class="col-span-2">
                            <p class="text-sm font-medium text-gray-500">Deskripsi</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stock Received History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Penerimaan Stok</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diterima Oleh</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($product->receivedLogs as $log)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $log->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $log->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $log->receivedByUser->name }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada penerimaan stok
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Warranty Registrations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Registrasi Garansi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Seri</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($product->warrantyRegistrations as $registration)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $registration->serial_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $registration->customer_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($registration->status === 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($registration->status === 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $registration->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.warranty.show', $registration) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada registrasi garansi
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>