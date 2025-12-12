<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulk Labels (Serial)</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .label { border: 1px solid #333; padding: 10px; width: 340px; margin: 8px; display: inline-block; vertical-align: top; }
        .row { margin-bottom: 5px; }
        .qr { width: 120px; height: 120px; border: 1px solid #999; }
        .mono { font-family: monospace; }
    </style>
</head>
<body>
@foreach($serials as $sn)
    <div class="label">
        <table width="100%">
            <tr>
                <td width="42%">
                    <img class="qr" src="data:image/svg+xml;base64,{{ $qrCodeSvgBase64 }}" alt="QR">
                </td>
                <td width="58%" valign="top">
                    <div class="row"><strong>{{ $sn->product->name }}</strong></div>
                    <div class="row mono">Part: {{ $sn->product->part_number }}</div>
                    <div class="row">Type: {{ $sn->product->type }}</div>
                    <div class="row mono">Serial: {{ $sn->serial_number }}</div>
                    <div class="row">Warranty: {{ $sn->product->warranty_period_months }} months</div>
                    <div class="row mono" style="font-size:9px;">{{ $registrationUrl }}</div>
                    <div class="row" style="font-size:9px;color:#555">QR Code Universal</div>
                </td>
            </tr>
        </table>
    </div>
@endforeach
</body>
</html>