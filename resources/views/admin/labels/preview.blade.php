<!-- filepath: resources/views/admin/labels/preview.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Preview Label</h2>
            <a href="{{ route('admin.labels.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto">
        <!-- Single Label Preview -->
        <div class="bg-white p-6 rounded-xl shadow mb-6">
            <h3 class="text-lg font-semibold mb-4">Preview Label Tunggal</h3>
            <div class="flex items-center gap-6 pb-6 mb-6">
                <img src="data:image/svg+xml;base64,{{ $qrCodeSvgBase64 }}" alt="QR" class="w-36 h-36 border" />
                <div>
                    <div class="text-sm text-gray-600">Produk</div>
                    <div class="font-semibold text-lg">{{ $product->name }}</div>
                    <div class="text-xs text-gray-500">{{ $product->part_number }}</div>
                    <div class="mt-2 text-sm">Type: {{ $product->type }}</div>
                    <div class="mt-2 font-mono text-sm">URL: {{ $registrationUrl }}</div>
                </div>
            </div>
            
            <a href="{{ route('admin.labels.download', $product) }}" 
               class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 rounded-xl">
                Download Single Label PDF
            </a>
        </div>

        <!-- Bulk Generate by Serials -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold mb-4">Generate Banyak Label (berdasarkan Serial)</h3>
            <p class="text-sm text-gray-600 mb-4">Pilih beberapa serial numbers untuk membuat banyak label sekaligus:</p>

            <form action="{{ route('admin.labels.bulk-serials') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    @if(isset($serials) && $serials->count())
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto rounded-xl bg-gray-100 p-4">
                            @foreach($serials as $serial)
                                <label class="flex items-center">
                                    <input type="checkbox" name="serial_ids[]" value="{{ $serial->id }}" 
                                           class="rounded border-gray-300">
                                    <span class="ml-2 text-sm font-mono">{{ $serial->serial_number }}</span>
                                </label>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 flex justify-between">
                            <button type="button" onclick="selectAll()" class="text-sm text-indigo-600 hover:text-indigo-900">
                                Select All
                            </button>
                            <button type="button" onclick="deselectAll()" class="text-sm text-gray-600 hover:text-gray-900">
                                Clear All
                            </button>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">
                                Generate Bulk PDF
                            </button>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Tidak ada serial number yang tersedia untuk produk ini.</p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        function selectAll() {
            document.querySelectorAll('input[name="serial_ids[]"]').forEach(cb => cb.checked = true);
        }
        function deselectAll() {
            document.querySelectorAll('input[name="serial_ids[]"]').forEach(cb => cb.checked = false);
        }
    </script>
</x-app-layout>