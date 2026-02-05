<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Services\BarcodeService;
use Illuminate\Console\Command;

class RegenerateBarcodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:regenerate-barcodes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate barcode data for all tickets using the new format';

    /**
     * Execute the console command.
     */
    public function handle(BarcodeService $barcodeService)
    {
        $tickets = Ticket::all();
        $this->info("Found {$tickets->count()} tickets. Regenerating barcodes...");

        foreach ($tickets as $ticket) {
            $oldBarcode = $ticket->barcode_data;
            
            // We need to pass the ticket data to the service
            // The service uses 'uuid' to generate the hash
            $ticket->barcode_data = $barcodeService->formatBarcodeData($ticket->toArray());
            $ticket->save();

            $this->line("Ticket ID {$ticket->id}: {$oldBarcode} -> {$ticket->barcode_data}");
        }

        $this->info('All ticket barcodes have been updated.');
    }
}
