<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Label</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .box { border: 1px solid #333; padding: 12px; width: 340px; }
        .row { margin-bottom: 6px; }
        .qr { width: 128px; height: 128px; border: 1px solid #999; }
        .mono { font-family: monospace; }
    </style>
</head>
<body>
<div class="box">
    <table width="100%">
        <tr>
            <td width="45%">
                <img class="qr" src="data:image/svg+xml;base64,{{ $qrCodeSvgBase64 }}" alt="QR">
            </td>
            <td width="55%" valign="top">
                <div class="row"><strong>{{ $product->name }}</strong></div>
                <div class="row mono">Part: {{ $product->part_number }}</div>
                <div class="row">Type: {{ $product->type }}</div>
                @isset($serialNumber)
                    <div class="row mono">Serial: {{ $serialNumber }}</div>
                @endisset
                <div class="row">Warranty: {{ $product->warranty_period_months }} months</div>
                <div class="row mono" style="font-size:10px;">{{ $registrationUrl }}</div>
                <div class="row" style="font-size:10px;color:#555">QR Code Universal</div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
