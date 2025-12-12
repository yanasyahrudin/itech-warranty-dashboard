<!-- filepath: resources/views/admin/labels/bulk-pdf.blade.php -->
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulk Product Labels</title>
    <style>
        @page {
            margin: 10px;
            size: landscape;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
        }

        /* WRAPPER LABEL */
        .label {
            border: 1px solid #333;
            padding: 10px;
            width: 320px;
            margin: 8px;
            display: inline-block;
            vertical-align: top;
            box-sizing: border-box;
            position: relative;
            page-break-inside: avoid;
        }

        /* QR SECTION */
        .qr {
            width: 120px;
            height: 120px;
            border: 1px solid #999;
            margin-bottom: 5px;
        }

        .mono {
            font-family: monospace;
        }

        .grid {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
@foreach($products as $product)
    <div class="label">
        <table width="100%">
            <tr>
                <td width="42%">
                    <img class="qr" src="data:image/svg+xml;base64,{{ $qrCodeSvgBase64 }}" alt="QR">
                </td>
                <td width="58%" valign="top">
                    <div class="row"><strong>{{ $product->name }}</strong></div>
                    <div class="row mono">Part: {{ $product->part_number }}</div>
                    <div class="row">Type: {{ $product->type }}</div>
                    <div class="row">Warranty: {{ $product->warranty_period_months }} months</div>
                    <div class="row mono" style="font-size:9px;">{{ $registrationUrl }}</div>
                    <div class="row" style="font-size:9px;color:#555">QR Code Universal</div>
                </td>
            </tr>
        </table>
    </div>
@endforeach
</body>
</html>
