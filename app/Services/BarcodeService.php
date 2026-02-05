<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Milon\Barcode\DNS1D;

class BarcodeService
{
    /**
     * Generate a QR Code as an SVG string.
     */
    public function generateQrCode(string $data, int $size = 200): string
    {
        return QrCode::size($size)->generate($data);
    }

    /**
     * Generate a 1D barcode (Code128) as an HTML snippet.
     */
    public function generateCode128(string $data): string
    {
        $d = new DNS1D();
        return $d->getBarcodeHTML($data, 'C128');
    }

    /**
     * Generate a unique data string for the ticket.
     */
    public function formatBarcodeData(array $details): string
    {
        // Generate a shorter, cleaner code for the barcode
        // Format: TICKET-XXXX-XXXX (derived from UUID checksum for determinism)
        $uuid = $details['uuid'] ?? uniqid();
        $hash = crc32($uuid);
        
        // Create an 8-digit string from the hash
        $numericHash = sprintf("%08u", $hash);
        $shortCode = substr($numericHash, -8);

        return "TICKET-" . substr($shortCode, 0, 4) . "-" . substr($shortCode, 4, 4);
    }
}
