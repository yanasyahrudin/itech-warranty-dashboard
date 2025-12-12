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
        // Paginate products (e.g., 12 per page)
        $products = \App\Models\Product::orderBy('part_number')
            ->paginate(12);

        // Preload available serials for products shown on this page
        $productIds = collect($products->items())->pluck('id');
        $availableSerials = \App\Models\ProductSerialNumber::whereIn('product_id', $productIds)
            ->where('status', 'available')
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
    public function generate(\App\Models\Product $product)
    {
        $registrationUrl = route('warranty.register');

        // Use SVG to avoid Imagick dependency
        $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)
            ->format('svg')
            ->generate($registrationUrl);
        $qrCodeSvgBase64 = base64_encode($qrSvg);

        $serials = $product->availableSerialNumbers()->limit(20)->get();

        return view('admin.labels.preview', [
            'product' => $product,
            'qrCodeSvgBase64' => $qrCodeSvgBase64,
            'registrationUrl' => $registrationUrl,
            'serials' => $serials,
        ]);
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
}