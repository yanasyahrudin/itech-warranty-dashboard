<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSerialNumber;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductLabelController extends Controller
{
    /**
     * Display product labels page with serial number selection
     */
    public function index()
    {
        // Hanya produk yang sudah punya serial "available"
        $products = Product::whereHas('serialNumbers', function ($q) {
                $q->where('status', 'available');
            })
            ->orderBy('part_number')
            ->paginate(12);

        // Ambil serial available untuk produk yang tampil di halaman ini
        $productIds = collect($products->items())->pluck('id');
        $availableSerials = ProductSerialNumber::whereIn('product_id', $productIds)
            ->where('status', 'available')
            ->orderBy('serial_number')
            ->get()
            ->groupBy('product_id');

        return view('admin.labels.index', compact('products', 'availableSerials'));
    }

    /**
     * Generate label for specific serial number
     */
    public function generateWithSerial(ProductSerialNumber $serialNumber)
    {
        $serialNumber->load('product');
        $product = $serialNumber->product;
        $registrationUrl = route('warranty.register');
        
        // Generate QR Code
        $qrCode = QrCode::size(150)
            ->format('png')
            ->generate($registrationUrl);
        
        $qrCodeBase64 = base64_encode($qrCode);
        
        return view('admin.labels.preview-serial', compact('product', 'serialNumber', 'qrCodeBase64', 'registrationUrl'));
    }

    /**
     * Download label PDF for specific serial number
     */
    public function downloadWithSerial(ProductSerialNumber $serialNumber)
    {
        $serialNumber->load('product');
        $product = $serialNumber->product;
        $registrationUrl = route('warranty.register');
        
        // Generate QR Code
        $qrCode = QrCode::size(150)
            ->format('png')
            ->generate($registrationUrl);
        
        $qrCodeBase64 = base64_encode($qrCode);
        
        $pdf = Pdf::loadView('admin.labels.pdf-serial', compact('product', 'serialNumber', 'qrCodeBase64', 'registrationUrl'));
        
        $filename = 'label-' . $serialNumber->serial_number . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Bulk generate labels with serial numbers
     */
    public function bulkGenerateWithSerials(Request $request)
    {
        $request->validate([
            'serial_numbers' => 'required|array|min:1',
            'serial_numbers.*' => 'exists:product_serial_numbers,id',
        ]);

        $serialNumbers = ProductSerialNumber::with('product')
            ->whereIn('id', $request->serial_numbers)
            ->get();

        $registrationUrl = route('warranty.register');
        $labels = [];

        foreach ($serialNumbers as $serialNumber) {
            $qrCode = QrCode::size(150)
                ->format('png')
                ->generate($registrationUrl);
            
            $labels[] = [
                'serial' => $serialNumber,
                'product' => $serialNumber->product,
                'qr_code' => base64_encode($qrCode),
            ];
        }

        $pdf = Pdf::loadView('admin.labels.bulk-pdf', compact('labels', 'registrationUrl'));
        
        $filename = 'labels-bulk-' . now()->format('Y-m-d-His') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Generate label preview for a product (without specific serial)
     */
    public function generate(Product $product)
    {
        $registrationUrl = route('warranty.register');
        $qrSvg = QrCode::size(150)->format('svg')->generate($registrationUrl);
        $qrCodeSvgBase64 = base64_encode($qrSvg);

        // Ambil semua serial available untuk produk ini
        $serials = $product->availableSerialNumbers()->get();

        return view('admin.labels.preview', compact('product', 'qrCodeSvgBase64', 'registrationUrl', 'serials'));
    }

    /**
     * Download product label PDF (without specific serial)
     */
    public function download(\App\Models\Product $product)
    {
        $registrationUrl = route('warranty.register');

        // Use SVG for PDF embedding
        $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)
            ->format('svg')
            ->generate($registrationUrl);
        $qrCodeSvgBase64 = base64_encode($qrSvg);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.labels.pdf', [
            'product' => $product,
            'qrCodeSvgBase64' => $qrCodeSvgBase64,
            'registrationUrl' => $registrationUrl,
        ]);

        $filename = 'label-' . ($product->part_number ?? ('product-' . $product->id)) . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Bulk generate labels for selected products (no specific serials)
     * Expects: product_ids[] (array)
     */
    public function bulkGenerate(Request $request)
    {
        $data = $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $products = Product::whereIn('id', $data['product_ids'])
            ->orderBy('part_number')
            ->get();

        $registrationUrl = route('warranty.register');

        // Pre-generate one SVG QR (same universal code) and reuse
        $qrSvg = QrCode::size(150)->format('svg')->generate($registrationUrl);
        $qrCodeSvgBase64 = base64_encode($qrSvg);

        $pdf = Pdf::loadView('admin.labels.bulk-pdf', [
            'products' => $products,
            'qrCodeSvgBase64' => $qrCodeSvgBase64,
            'registrationUrl' => $registrationUrl,
        ]);

        $filename = 'labels-bulk-' . now()->format('Ymd-His') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Preview label untuk Serial Number tertentu
     */
    public function serialGenerate(ProductSerialNumber $serial)
    {
        $product = $serial->product;
        $registrationUrl = route('warranty.register');

        // QR SVG (hindari imagick)
        $qrSvg = QrCode::size(150)->format('svg')->generate($registrationUrl);
        $qrCodeSvgBase64 = base64_encode($qrSvg);

        return view('admin.labels.preview-serial', [
            'product' => $product,
            'serial' => $serial,
            'qrCodeSvgBase64' => $qrCodeSvgBase64,
            'registrationUrl' => $registrationUrl,
        ]);
    }

    /**
     * Download PDF label untuk Serial Number tertentu
     */
    public function serialDownload(ProductSerialNumber $serial)
    {
        $product = $serial->product;
        $registrationUrl = route('warranty.register');

        $qrSvg = QrCode::size(140)->format('svg')->generate($registrationUrl);
        $qrCodeSvgBase64 = base64_encode($qrSvg);

        $pdf = Pdf::loadView('admin.labels.pdf', [
            'product' => $product,
            'serialNumber' => $serial->serial_number,
            'qrCodeSvgBase64' => $qrCodeSvgBase64,
            'registrationUrl' => $registrationUrl,
        ]);

        $filename = 'label-' . ($product->part_number ?? 'product') . '-' . $serial->serial_number . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Bulk generate PDF labels berdasarkan daftar Serial IDs
     * Expects: serial_ids[] (array of ProductSerialNumber IDs)
     */
    public function bulkGenerateBySerials(Request $request)
    {
        $data = $request->validate([
            'serial_ids' => 'required|array|min:1',
            'serial_ids.*' => 'integer|exists:product_serial_numbers,id',
        ]);

        $serials = ProductSerialNumber::with('product')
            ->whereIn('id', $data['serial_ids'])
            ->orderBy('product_id')
            ->orderBy('serial_number')
            ->get();

        $registrationUrl = route('warranty.register');
        $qrSvg = QrCode::size(120)->format('svg')->generate($registrationUrl);
        $qrCodeSvgBase64 = base64_encode($qrSvg);

        $pdf = Pdf::loadView('admin.labels.bulk-serials-pdf', [
            'serials' => $serials,
            'qrCodeSvgBase64' => $qrCodeSvgBase64,
            'registrationUrl' => $registrationUrl,
        ]);

        $filename = 'labels-serials-' . now()->format('Ymd-His') . '.pdf';
        return $pdf->download($filename);
    }
}