<!-- filepath: resources/views/admin/warehouse/received-print.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-500 leading-tight">
                Print Serial Numbers
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.warehouse.received.download', $transaction) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition">
                    📥 Download PDF
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition">
                    🖨️ Print
                </button>
                <a href="{{ route('admin.warehouse.received.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Print Area -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8" id="printArea">

                <!-- Header Info -->
                <div class="mb-8 pb-6 border-b-2 border-gray-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Serial Numbers List</h1>
                            <p class="text-sm text-gray-600">Transaction ID: #{{ $transaction->id }}</p>
                            <p class="text-sm text-gray-600">Date: {{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="text-right items-center justify-center">
                            <!-- <div class="text-2xl font-bold text-indigo-600 mb-1">iTech</div> -->
                            <div class="">
                                <img src="https://res.cloudinary.com/dcbryptkx/image/upload/v1765004406/itech-warranty-qr/LogoItech_z57jdx.png" alt="" class="">
                            </div>
                            <p class="text-xs text-gray-500">Warranty Management System</p>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="mb-8 p-6 bg-indigo-50 border border-indigo-200 rounded-xl">
                    <h3 class="text-lg font-semibold text-indigo-900 mb-4">Product Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-indigo-700 font-semibold">Part Number</p>
                            <p class="text-base font-bold text-indigo-900">{{ $transaction->product->part_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-700 font-semibold">Product Name</p>
                            <p class="text-base font-bold text-indigo-900">{{ $transaction->product->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-700 font-semibold">Product Type</p>
                            <p class="text-base font-bold text-indigo-900">{{ $transaction->product->type }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-700 font-semibold">Quantity Received</p>
                            <p class="text-base font-bold text-indigo-900">{{ $transaction->quantity }} units</p>
                        </div>
                    </div>
                </div>

                <!-- Serial Numbers Table -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Generated Serial Numbers ({{ $serialNumbers->count() }})</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                        No.
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                        Serial Number
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Signature
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($serialNumbers as $index => $serial)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-r">
                                        <span class="text-sm font-mono font-bold text-indigo-600">
                                            {{ $serial->serial_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-r">
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
                <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-xl print:hidden">
                    <h4 class="font-semibold text-yellow-900 mb-2">📋 Instructions:</h4>
                    <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
                        <li>Print this document and attach serial number stickers to each product unit</li>
                        <li>Each serial number is unique and cannot be duplicated</li>
                        <li>Sign in the signature column after attaching the serial number</li>
                        <li>Keep this document for inventory tracking records</li>
                    </ul>
                </div>

                <!-- Footer -->
                <div class="mt-12 pt-6 border-t border-gray-300">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Prepared By:</p>
                            <div class="border-b border-gray-400 mb-2 pb-8"></div>
                            <p class="text-xs text-gray-600">({{ auth()->user()->name }})</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Verified By:</p>
                            <div class="border-b border-gray-400 mb-2 pb-8"></div>
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