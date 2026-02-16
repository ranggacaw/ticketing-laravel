<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use App\Models\TicketType;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [
            Stat::make('Total Tickets', Ticket::count())
                ->description(Ticket::whereNull('scanned_at')->count() . ' Unvalidated')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary'),

            Stat::make('Validated Tickets', Ticket::whereNotNull('scanned_at')->count())
                ->description('Checked in guests')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Revenue', Number::currency(Ticket::sum('price'), 'IDR'))
                ->description('Total ticket value')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];

        // Add stats for each ticket type
        $ticketTypes = TicketType::withCount('tickets')->get();
        foreach ($ticketTypes as $type) {
             $stats[] = Stat::make($type->name . ' Sold', $type->tickets_count)
                ->description('Inventory: ' . $type->quantity)
                ->color('gray');
        }

        return $stats;
    }
}
