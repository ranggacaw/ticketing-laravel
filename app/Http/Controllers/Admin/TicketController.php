<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\BarcodeService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    protected $barcodeService;

    public function __construct(BarcodeService $barcodeService)
    {
        $this->barcodeService = $barcodeService;
    }

    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('admin.tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'seat_number' => 'required|string|unique:tickets,seat_number',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string',
        ]);

        $ticket = Ticket::create($validated);
        
        // Generate specific barcode data string
        $ticket->barcode_data = $this->barcodeService->formatBarcodeData($ticket->toArray());
        $ticket->save();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket generated successfully.');
    }

    public function show(Ticket $ticket)
    {
        $qrCode = $this->barcodeService->generateQrCode($ticket->barcode_data);
        $barcode128 = $this->barcodeService->generateCode128($ticket->barcode_data);

        return view('admin.tickets.show', compact('ticket', 'qrCode', 'barcode128'));
    }

    public function export(Ticket $ticket)
    {
        $qrCode = base64_encode($this->barcodeService->generateQrCode($ticket->barcode_data, 150));
        
        $pdf = Pdf::loadView('admin.tickets.pdf', compact('ticket', 'qrCode'));
        return $pdf->download("ticket-{$ticket->uuid}.pdf");
    }

    public function edit(Ticket $ticket)
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'seat_number' => 'required|string|unique:tickets,seat_number,' . $ticket->id,
            'price' => 'required|numeric|min:0',
            'type' => 'required|string',
        ]);

        $ticket->update($validated);
        
        // Refresh barcode data if seat or type changed
        $ticket->barcode_data = $this->barcodeService->formatBarcodeData($ticket->toArray());
        $ticket->save();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
