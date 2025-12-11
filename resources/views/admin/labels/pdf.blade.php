<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Label - {{ $product->part_number }}</title>

<style>
    @page {
        size: 100mm 50mm;
        margin: 0;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: DejaVu Sans, Arial, sans-serif;
        position: relative;
        width: 100mm;
        height: 50mm;
    }

    /* BORDER */
    .border-box {
        position: absolute;
        top: 2mm;
        left: 2mm;
        width: 96mm;
        height: 46mm;
        border: 1px solid #000;
    }

    /* QR AREA */
    .qr {
        position: absolute;
        top: 5mm;
        left: 5mm;
        width: 32mm;
        height: 32mm;
        text-align: center;
    }

    .qr svg {
        width: 30mm !important;
        height: 30mm !important;
    }

    .qr-text {
        font-size: 7pt;
        margin-top: 1mm;
    }

    /* TEXT AREA */
    .info {
        position: absolute;
        top: 5mm;
        left: 42mm;
        width: 53mm;
        height: 40mm;
    }

    .field-label {
        font-size: 7pt;
        color: #555;
        text-transform: uppercase;
        margin-bottom: 0.5mm;
    }

    .field-value {
        font-size: 10pt;
        font-weight: bold;
        margin-bottom: 2mm;
        white-space: normal;          /* ALLOW WRAP */
        word-break: break-word;       /* BREAK LONG WORDS */
        line-height: 1.1;             /* Tighter spacing */
    }

    .large { font-size: 12pt; }
    .medium { font-size: 9pt; }

    .warranty {
        position: absolute;
        bottom: 1mm;
        font-size: 8pt;
        width: 50mm;
        border-top: 1px solid #ccc;
        padding-top: 1mm;
    }

    /* FOOTER */
    .footer {
        position: absolute;
        bottom: -6mm;
        width: 100mm;
        text-align: center;
        font-size: 6.5pt;
        color: #777;
    }
</style>

</head>

<body>

<div class="border-box"></div>

<div class="qr">
    {!! $qrCode !!}
    <div class="qr-text">Scan for Warranty</div>
</div>

<div class="info">

    <div class="field-label">Part Number</div>
    <div class="field-value large">{{ $product->part_number }}</div>

    <div class="field-label">Product Name</div>
    <div class="field-value medium">{{ $product->name }}</div>

    <div class="field-label">Type</div>
    <div class="field-value medium">{{ $product->type }}</div>

    <div class="field-label">Serial Number</div>
    <div class="field-value medium">{{ $product->serial_number }}</div>

    <div class="warranty">
        <strong>Warranty:</strong> {{ $product->warranty_period_months }} months
    </div>

</div>

<div class="footer">
    Itech Warranty System | {{ $qrCodeUrl }}
</div>

</body>
</html>
