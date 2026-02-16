<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketExportController extends Controller
{
    public function __invoke(Ticket $ticket)
    {
        // Generate QR Code as Base64
        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($ticket->uuid));
        
        $pdf = Pdf::loadView('tickets.pdf', [
            'ticket' => $ticket,
            'qrCode' => $qrCode
        ]);
        
        return $pdf->download("ticket-{$ticket->uuid}.pdf");
    }
}
