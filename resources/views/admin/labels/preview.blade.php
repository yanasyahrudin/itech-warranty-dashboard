<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Product Label Preview</h2>
            <a href="{{ route('admin.labels.download', $product) }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Download PDF</a>
        </div>
    </x-slot>
    <div class="py-8 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <div class="flex items-center gap-6">
                <img src="data:image/svg+xml;base64,{{ $qrCodeSvgBase64 }}" alt="QR" class="w-36 h-36 border" />
                <div>
                    <div class="text-sm text-gray-600">Registration URL</div>
                    <div class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $registrationUrl }}</div>
                    <div class="mt-4">
                        <div class="text-sm text-gray-600">Product</div>
                        <div class="font-semibold">{{ $product->name }} ({{ $product->part_number }})</div>
                        <div class="text-xs text-gray-500">Type: {{ $product->type }}</div>
                    </div>
                </div>
            </div>

            @if(isset($serials) && $serials->count())
                <div class="mt-6">
                    <div class="text-sm font-semibold text-gray-700 mb-2">Available Serials (pick for serial-specific label):</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($serials as $sn)
                            <a href="{{ route('admin.labels.serial.generate', $sn) }}" class="px-3 py-2 border rounded text-sm hover:bg-gray-50">
                                {{ $sn->serial_number }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>