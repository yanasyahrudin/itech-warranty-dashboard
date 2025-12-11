<!-- filepath: resources/views/admin/labels/pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Label - {{ $product->part_number }}</title>
    <style>
        @page {
            margin: 0;
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
            margin-bottom: 0.3cm;
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
            font-size: 14pt;
        }
        .field-value.medium {
            font-size: 10pt;
        }
        .warranty-info {
            margin-top: 0.3cm;
            padding-top: 0.2cm;
            border-top: 1px solid #e0e0e0;
            font-size: 8pt;
            color: #444;
        }
        .footer {
            text-align: center;
            font-size: 7pt;
            color: #999;
            margin-top: 0.2cm;
        }
    </style>
</head>
<body>
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
                    <div class="field-value large">{{ $product->part_number }}</div>
                </div>
                
                <div class="field">
                    <div class="field-label">Product Name</div>
                    <div class="field-value medium">{{ $product->name }}</div>
                </div>
                
                <div class="field">
                    <div class="field-label">Type</div>
                    <div class="field-value medium">{{ $product->type }}</div>
                </div>
                
                <div class="warranty-info">
                    <strong>Warranty:</strong> {{ $product->warranty_period_months }} months
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer">
        iTech Warranty System | {{ $qrCodeUrl }}
    </div>
</body>
</html>