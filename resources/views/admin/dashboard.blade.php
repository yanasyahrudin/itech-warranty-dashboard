<!-- filepath: resources/views/admin/dashboard.blade.php -->
 
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Total Products -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500">Total Products</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['total_products'] }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Registrations -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500">Total Registrations</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['total_registrations'] }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Registrations -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500">Pending Reviews</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['pending_registrations'] }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approved Registrations -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500">Approved</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['approved_registrations'] }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected Registrations -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500">Rejected</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['rejected_registrations'] }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Warehouse Logs -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500">Warehouse Logs</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['warehouse_logs'] }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Registrations -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Warranty Registrations</h3>
                        <div class="space-y-3">
                            @forelse($recent_registrations as $registration)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $registration->serial_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $registration->product->name }}</p>
                                </div>
                                <div class="text-right">
                                    @if($registration->status === 'pending')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($registration->status === 'approved')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">{{ $registration->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 text-center py-4">No registrations yet</p>
                            @endforelse
                        </div>
                        <a href="{{ route('admin.warranty.index') }}" class="mt-4 block text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            View all →
                        </a>
                    </div>
                </div>

                <!-- Recent Warehouse Logs -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Warehouse Activity</h3>
                        <div class="space-y-3">
                            @forelse($recent_warehouse_logs as $log)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $log->product->part_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $log->product->name }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">+{{ $log->quantity }}</span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 text-center py-4">No warehouse logs yet</p>
                            @endforelse
                        </div>
                        <a href="{{ route('admin.warehouse.received.index') }}" class="mt-4 block text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            View all →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>