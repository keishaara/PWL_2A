<?php

namespace App\Support;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class TicketQr
{
    public static function dataUri(string $ticketCode, int $size = 240): string
    {
        $qr = new QrCode(
            data: $ticketCode,
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: $size,
            margin: 8,
        );

        return (new PngWriter())->write($qr)->getDataUri();
    }
}