<!-- filepath: resources/views/admin/labels/bulk-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulk Product Labels</title>
    <style>
        @page {
            margin: 0.5cm;
            size: landscape;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .label-container {
            width: 10cm;
            height: 5cm;
            border: 2px solid #333;
            padding: 0.5cm;
            box-sizing: border-box;
            display: table;
            page-break-inside: avoid;
            margin-bottom: 0.5cm;
        }
        .label-content {
            display: table-row;
        }
        .qr-section {
            display: table-cell;
            width: 40%;
            text-align: center;
            vertical-align: middle;
            border-right: 1px solid #ccc;
            padding-right: 0.3cm;
        }
        .qr-section svg {
            width: 3.5cm;
            height: 3.5cm;
        }
        .qr-text {
            font-size: 8pt;
            color: #666;
            margin-top: 5px;
        }
        .info-section {
            display: table-cell;
            width: 60%;
            vertical-align: middle;
            padding-left: 0.4cm;
        }
        .field {
            margin-bottom: 0.25cm;
        }
        .field-label {
            font-size: 7pt;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .field-value {
            font-size: 11pt;
            font-weight: bold;
            color: #000;
        }
        .field-value.large {
            font-size: 13pt;
        }
        .field-value.medium {
            font-size: 9pt;
        }
        .serial-number {
            background: #f0f0f0;
            padding: 3px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .warranty-info {
            margin-top: 0.2cm;
            padding-top: 0.15cm;
            border-top: 1px solid #e0e0e0;
            font-size: 7pt;
            color: #444;
        }
    </style>
</head>
<body>
    @foreach($labels as $label)
        <div class="label-container">
            <div class="label-content">
                <!-- QR Code Section -->
                <div class="qr-section">
                    {!! $qrCode !!}
                    <div class="qr-text">Scan for Warranty</div>
                </div>
                
                <!-- Product Info Section -->
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
                    
                    <div class="warranty-info">
                        <strong>Type:</strong> {{ $label['product']->type }} | 
                        <strong>Warranty:</strong> {{ $label['product']->warranty_period_months }} months
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>