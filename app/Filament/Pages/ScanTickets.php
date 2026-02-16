<?php

namespace App\Filament\Pages;

use App\Models\Event;
use App\Models\Ticket;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\On;

class ScanTickets extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationLabel = 'Scan Tickets';

    protected static ?string $title = 'Scan Tickets';

    protected string $view = 'filament.pages.scan-tickets';

    public ?string $manualCode = null;

    #[On('scan-success')]
    public function handleScan(string $code): void
    {
        $this->checkCode($code);
    }

    public function checkManualCode(): void
    {
        $this->validate([
            'manualCode' => ['required', 'string'],
        ]);

        $this->checkCode($this->manualCode);
        $this->manualCode = '';
    }

    protected function checkCode(string $code): void
    {
        // Simple search by barcode_data or uuid (the barcode_data defaults to uuid)
        $ticket = Ticket::where('barcode_data', $code)
            ->orWhere('uuid', $code)
            ->first();

        if (!$ticket) {
            Notification::make()
                ->title('Invalid Ticket')
                ->body("No ticket found with code: {$code}")
                ->danger()
                ->persistent() // Keep it visible so they see it
                ->send();

            $this->dispatch('scan-completed', success: false);

            return;
        }

        // Check if already scanned?
        // Typically invalid if scanned before, or just warning.
        // User didn't specify strict rule, but "scanned_at" exists in model implies tracking.

        if ($ticket->scanned_at) {
            Notification::make()
                ->title('Already Scanned')
                ->body("Ticket for {$ticket->user_name} was already scanned at {$ticket->scanned_at->format('H:i d/m/Y')}.")
                ->warning()
                ->persistent()
                ->send();

            $this->dispatch('scan-completed', success: false);
            return;
        }

        // Mark as scanned
        $ticket->update([
            'scanned_at' => now(),
            'status' => 'scanned', // Assuming status column exists and 'scanned' is valid or use 'used'
        ]);

        $typeName = $ticket->ticketType->name ?? 'General';

        Notification::make()
            ->title('Scanned Successfully')
            ->body("Valid ticket for {$ticket->user_name} ({$typeName}).")
            ->success()
            ->persistent()
            ->send();

        // Dispatch event for UI feedback if needed (e.g. sound)
        $this->dispatch('scan-completed', success: true);
    }
}
