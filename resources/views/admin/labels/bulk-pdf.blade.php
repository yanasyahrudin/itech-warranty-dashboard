<!-- filepath: resources/views/admin/labels/bulk-pdf.blade.php -->
<!DOCTYPE html>
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
        }

        /* WRAPPER LABEL */
        .label-container {
            width: 100mm;
            height: 50mm;
            border: 1px solid #000;
            box-sizing: border-box;
            margin-bottom: 8mm;
            padding: 3mm;
            position: relative;
            page-break-inside: avoid;
        }

        /* FLEX LAYOUT AGAR STABIL */
        .label-flex {
            display: flex;
            flex-direction: row;
            height: 100%;
        }

        /* QR SECTION */
        .qr-section {
            width: 35mm;
            text-align: center;
            padding-right: 3mm;
            border-right: 1px solid #ccc;
        }

        .qr-section svg {
            width: 30mm !important;
            height: 30mm !important;
        }

        .qr-text {
            font-size: 7pt;
            margin-top: 2mm;
            color: #555;
        }

        /* INFO SECTION */
        .info-section {
            flex: 1;
            padding-left: 3mm;
        }

        .field-label {
            font-size: 7pt;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 1mm;
        }

        .field-value {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 2mm;
            line-height: 1.1;
            word-break: break-word;
        }

        .large { font-size: 12pt; }
        .medium { font-size: 9pt; }

        .serial-number {
            background: #efefef;
            padding: 2px 4px;
            border-radius: 3px;
            font-family: "Courier New", monospace;
        }

        /* Warranty Section */
        .warranty-info {
            position: absolute;
            bottom: 2mm;
            left: 40mm;
            right: 3mm;
            font-size: 7pt;
            padding-top: 2mm;
            border-top: 1px solid #ccc;
            color: #333;
        }
    </style>
</head>

<body>
@foreach($labels as $label)
    <div class="label-container">
        <div class="label-flex">

            <!-- QR CODE (unique per label) -->
            <div class="qr-section">
                {!! $qrCode !!}
                <div class="qr-text">Scan for Warranty</div>
            </div>

            <!-- PRODUCT INFO -->
            <div class="info-section">

                <div class="field">
                    <div class="field-label">Part Number</div>
                    <div class="field-value large">{{ $label['product']->part_number }}</div>
                </div>

                <div class="field">
                    <div class="field-label">Product Name</div>
                    <div class="field-value medium">{{ $label['product']->name }}</div>
                </div>

                <div class="field">
                    <div class="field-label">Serial Number</div>
                    <div class="field-value medium serial-number">{{ $label['serial_number'] }}</div>
                </div>

            </div>
        </div>

        <div class="warranty-info">
            <strong>Type:</strong> {{ $label['product']->type }} |
            <strong>Warranty:</strong> {{ $label['product']->warranty_period_months }} months
        </div>
    </div>
@endforeach
</body>
</html>
