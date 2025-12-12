<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Product Label Preview</h2>
            <a href="{{ route('admin.labels.download', $product) }}" class="px-4 py-2 text-gray-600 rounded">Download PDF</a>
        </div>
    </x-slot>
    <div class="py-8 max-w-7xl mx-auto mt-6 flex">
        <div class="bg-white p-6 rounded shadow">
            <div class="flex items-center gap-6">
                <img src="data:image/svg+xml;base64,{{ $qrCodeSvgBase64 }}" alt="QR" class="w-36 h-36 rounded-xl" />
                <div class="px-4">
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
                <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach($serials as $sn)
                    <a href="{{ route('admin.labels.serial.generate', $sn) }}" class="px-3 py-2 border rounded text-sm hover:bg-gray-50">
                        {{ $sn->serial_number }}
                    </a>
                    @endforeach
                </div> -->

                <div class="mt-6">
                    <ul class="list-disc list-inside text-sm text-gray-600">
                        @foreach($serials as $sn)
                        <li class="mb-6">
                            <a href="{{ route('admin.labels.serial.generate', $sn) }}" class="px-3 py-2 border rounded-xl text-sm hover:bg-gray-50">
                            {{ $sn->serial_number }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>