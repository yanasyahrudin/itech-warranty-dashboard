<!-- filepath: resources/views/admin/qr-code/preview.blade.php -->
@if($base64)
    <img src="data:image/png;base64,{{ $base64 }}" alt="QR Code">
@endif