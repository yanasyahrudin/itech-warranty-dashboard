<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductLabelController extends Controller
{
    /**
     * Display product label generator page
     */
    public function index()
    {
        $products = Product::orderBy('part_number')->paginate(15);
        
        return view('admin.labels.index', compact('products'));
    }

    /**
     * Generate single product label preview
     */
    public function generate(Product $product)
    {
        // Universal QR Code URL
        $qrCodeUrl = route('warranty.register');
        
        // Generate QR Code as SVG (no extension needed)
        $qrCode = QrCode::size(200)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($qrCodeUrl);

        return view('admin.labels.generate', compact('product', 'qrCode', 'qrCodeUrl'));
    }

    /**
     * Download single product label as PDF
     */
    public function download(Product $product)
    {
        // Universal QR Code URL
        $qrCodeUrl = route('warranty.register');
        
        // Generate QR Code as SVG
        $qrCode = QrCode::size(300)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($qrCodeUrl);

        $data = [
            'product' => $product,
            'qrCode' => $qrCode,
            'qrCodeUrl' => $qrCodeUrl,
        ];

        $pdf = Pdf::loadView('admin.labels.pdf', $data)
            ->setPaper([0, 0, 283.46, 141.73], 'landscape'); // 10cm x 5cm in points

        return $pdf->download('label-' . $product->part_number . '.pdf');
    }

    /**
     * Bulk generate labels for multiple products
     */
    public function bulkGenerate(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $products = Product::whereIn('id', $request->product_ids)->get();
        
        // Universal QR Code URL
        $qrCodeUrl = route('warranty.register');
        
        // Generate QR Code as SVG
        $qrCode = QrCode::size(300)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($qrCodeUrl);

        $labels = [];
        foreach ($products as $product) {
            // Generate multiple labels based on quantity
            for ($i = 1; $i <= $request->quantity; $i++) {
                $labels[] = [
                    'product' => $product,
                    'serial_number' => $product->part_number . '-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                    // str_pad($i, 5, '0', STR_PAD_LEFT) = 00001, 00002, dst
                    'label_number' => $i,
                ];
            }
        }

        $data = [
            'labels' => $labels,
            'qrCode' => $qrCode,
            'qrCodeUrl' => $qrCodeUrl,
        ];

        $pdf = Pdf::loadView('admin.labels.bulk-pdf', $data)
            ->setPaper([0, 0, 283.46, 141.73], 'landscape'); // 10cm x 5cm

        return $pdf->download('labels-bulk-' . now()->format('YmdHis') . '.pdf');
    }
}