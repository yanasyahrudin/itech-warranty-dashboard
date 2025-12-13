<!-- filepath: resources/views/admin/warehouse/issued-index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-500 leading-tight">
                Warehouse - Product Issued
            </h2>
            <a href="{{ route('admin.warehouse.issued.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                New Issued
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="text-sm text-gray-600 mb-1">Total Transactions</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['total_transactions'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="text-sm text-gray-600 mb-1">Total Quantity</div>
                    <div class="text-2xl font-bold text-red-600">{{ number_format($stats['total_quantity']) }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="text-sm text-gray-600 mb-1">Today Transactions</div>
                    <div class="text-2xl font-bold text-orange-600">{{ $stats['today_transactions'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                    <div class="text-sm text-gray-600 mb-1">Today Quantity</div>
                    <div class="text-2xl font-bold text-orange-600">{{ number_format($stats['today_quantity']) }}</div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Transactions</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full ">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Destination</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white ">
                                @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        #{{ $transaction->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $transaction->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-semibold text-gray-900">{{ $transaction->product->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $transaction->product->part_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            -{{ $transaction->quantity }} units
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                        {{ $transaction->destination }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $transaction->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $transaction->notes ?? '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        No transactions found. Create your first issued transaction!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>