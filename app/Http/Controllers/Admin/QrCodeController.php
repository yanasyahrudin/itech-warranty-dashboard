<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    /**
     * Display QR code management page
     */
    public function index()
    {
        $registrationUrl = route('warranty.register');
        
        return view('admin.qr-code.index', compact('registrationUrl'));
    }

    /**
     * Preview QR code
     */
    public function preview(Request $request)
    {
        $size = $request->input('size', 200); // Default 200px
        $registrationUrl = route('warranty.register');
        
        // Generate QR code as SVG
        $qrCode = QrCode::size($size)
            ->format('svg')
            ->generate($registrationUrl);
        
        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Download QR code
     */
    public function download(Request $request)
    {
        $format = $request->input('format', 'png'); // png or pdf
        $size = $request->input('size', 300);
        $registrationUrl = route('warranty.register');
        
        $filename = 'qr-code-warranty-registration.' . $format;
        
        if ($format === 'png') {
            $qrCode = QrCode::size($size)
                ->format('png')
                ->generate($registrationUrl);
            
            return response($qrCode)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } 
        
        if ($format === 'svg') {
            $qrCode = QrCode::size($size)
                ->format('svg')
                ->generate($registrationUrl);
            
            return response($qrCode)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Content-Disposition', 'attachment; filename="qr-code-warranty-registration.svg"');
        }
        
        // PDF format
        $qrCode = QrCode::size($size)
            ->format('png')
            ->generate($registrationUrl);
        
        // Create PDF with QR code
        $pdf = \PDF::loadView('admin.qr-code.pdf', [
            'qrCode' => base64_encode($qrCode),
            'url' => $registrationUrl,
            'size' => $size
        ]);
        
        return $pdf->download($filename);
    }
}