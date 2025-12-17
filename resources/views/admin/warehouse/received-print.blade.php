<!-- filepath: resources/views/admin/warehouse/received-print.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-500 leading-tight">
                Cetak Serial Number
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.warehouse.received.download', $transaction) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition">
                    Unduh PDF
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition">
                    Cetak
                </button>
                <a href="{{ route('admin.warehouse.received.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Print Area -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8" id="printArea">

                <!-- Header Info -->
                <div class="mb-8 pb-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Serial Number</h1>
                            <p class="text-sm text-gray-600">ID Transaksi: #{{ $transaction->id }}</p>
                            <p class="text-sm text-gray-600">Tanggal: {{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="text-right items-center justify-center">
                            <!-- <div class="text-2xl font-bold text-indigo-600 mb-1">iTech</div> -->
                            <div class="">
                                <img src="https://res.cloudinary.com/dcbryptkx/image/upload/v1765004406/itech-warranty-qr/LogoItech_z57jdx.png" alt="" class="">
                            </div>
                            <p class="text-xs text-gray-500">Sistem Manajemen Garansi</p>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="mb-8 p-6 bg-indigo-50 rounded-xl">
                    <h3 class="text-lg font-semibold text-indigo-900 mb-4">Informasi Produk</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-indigo-700 font-semibold">Part Number</p>
                            <p class="text-base font-bold text-indigo-900">{{ $transaction->product->part_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-700 font-semibold">Nama Produk</p>
                            <p class="text-base font-bold text-indigo-900">{{ $transaction->product->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-700 font-semibold">Tipe Produk</p>
                            <p class="text-base font-bold text-indigo-900">{{ $transaction->product->type }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-700 font-semibold">Jumlah Diterima</p>
                            <p class="text-base font-bold text-indigo-900">{{ $transaction->quantity }} units</p>
                        </div>
                    </div>
                </div>

                <!-- Serial Numbers Table -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Nomor Seri yang Dihasilkan ({{ $serialNumbers->count() }})</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full ">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        No.
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Serial Number
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanda Tangan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white ">
                                @foreach($serialNumbers as $index => $serial)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono font-bold text-indigo-600">
                                            {{ $serial->serial_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ ucfirst($serial->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <!-- Space for manual signature -->
                                        <div class="h-8 border-b border-gray-300"></div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mt-8 p-4 bg-yellow-50  rounded-xl print:hidden">
                    <h4 class="font-semibold text-yellow-900 mb-2">📋 Instruksi:</h4>
                    <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
                        <li>Cetak dokumen ini dan tempelkan stiker nomor seri pada setiap unit produk</li>
                        <li>Setiap nomor seri unik dan tidak boleh diduplikasi</li>
                        <li>Berikan tanda tangan di kolom tanda tangan setelah menempelkan nomor seri</li>
                        <li>Simpan dokumen ini untuk catatan pelacakan inventaris</li>
                    </ul>
                </div>

                <!-- Footer -->
                <div class="mt-12 pt-6">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Disiapkan Oleh:</p>
                            <div class=" mb-2 pb-8"></div>
                            <p class="text-xs text-gray-600">({{ auth()->user()->name }})</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Diverifikasi Oleh:</p>
                            <div class=" mb-2 pb-8"></div>
                            <p class="text-xs text-gray-600">(Warehouse Manager)</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printArea,
            #printArea * {
                visibility: visible;
            }

            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print\:hidden {
                display: none !important;
            }
        }
    </style>
</x-app-layout>