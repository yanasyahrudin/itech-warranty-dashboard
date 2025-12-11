<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\QrCodeService;
use Symfony\Component\HttpFoundation\Response;

class QrCodeController extends Controller
{
    /**
     * Tampilkan halaman download QR Code
     */
    public function index()
    {
        return view('admin.qr-code.index');
    }

    /**
     * Download QR Code sebagai PNG
     */
    public function downloadPng()
    {
        $result = QrCodeService::generateWarrantyQrCode();

        return response($result->getString(), 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="warranty-qr-code.png"');
    }

    /**
     * Download QR Code sebagai SVG
     */
    public function downloadSvg()
    {
        $result = QrCodeService::generateWarrantyQrCodeSvg();

        return response($result->getString(), 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="warranty-qr-code.svg"');
    }

    /**
     * Preview QR Code
     */
    public function preview()
    {
        $result = QrCodeService::generateWarrantyQrCode();
        $base64 = base64_encode($result->getString());
        
        return view('admin.qr-code.preview', compact('base64'));
    }
}