<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateUniversalQrCode extends Command
{
    protected $signature = 'qr:generate';
    protected $description = 'Generate universal QR code for warranty registration';

    public function handle()
    {
        $url = config('app.url') . '/warranty/register';
        
        $qrCode = QrCode::size(500)
            ->format('png')
            ->generate($url);

        $path = public_path('qr-code-universal.png');
        file_put_contents($path, $qrCode);

        $this->info('Universal QR Code generated successfully at: ' . $path);
    }
}