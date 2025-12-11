<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\Result\ResultInterface;

class QrCodeService
{
    /**
     * Generate QR Code untuk warranty registration
     * URL: /warranty/register
     */
    public static function generateWarrantyQrCode(): ResultInterface
    {
        $url = route('warranty.register');
        
        $qrCode = new QrCode(
            new Encoding('UTF-8'),
            ErrorCorrectionLevel::High,
            new \Endroid\QrCode\Size\Size(300),
            new RoundBlockSizeMode(\Endroid\QrCode\RoundBlockSizeMode::Margin)
        );

        $qrCode->addData($url);
        $qrCode->setEncoding(new Encoding('UTF-8'));

        $writer = new PngWriter();
        return $writer->write($qrCode);
    }

    /**
     * Generate SVG QR Code
     */
    public static function generateWarrantyQrCodeSvg(): ResultInterface
    {
        $url = route('warranty.register');
        
        $qrCode = new QrCode(
            new Encoding('UTF-8'),
            ErrorCorrectionLevel::High,
            new \Endroid\QrCode\Size\Size(300),
            new RoundBlockSizeMode(\Endroid\QrCode\RoundBlockSizeMode::Margin)
        );

        $qrCode->addData($url);
        $qrCode->setEncoding(new Encoding('UTF-8'));

        $writer = new SvgWriter();
        return $writer->write($qrCode);
    }
}