<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTicketsSold = Ticket::count();
        $totalRevenue = Ticket::sum('price');
        $ticketsValidated = Ticket::whereNotNull('scanned_at')->count();
        $ticketsNotValidated = Ticket::whereNull('scanned_at')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalAttendees = Ticket::distinct('user_id')->count('user_id');

        return [
            // Row 1: Total Tickets Sold, Total Revenue, Validated Tickets, Pending Payments
            Stat::make('Total Tickets Sold', $totalTicketsSold)
                ->description($ticketsNotValidated . ' pending check-in')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary')
                ->columnSpan(1),

            Stat::make('Total Revenue', Number::currency($totalRevenue, 'IDR'))
                ->description('From all ticket sales')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->columnSpan(1),

            Stat::make('Validated Tickets', $ticketsValidated)
                ->description('Checked in guests')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->columnSpan(1),

            Stat::make('Pending Payments', $pendingPayments)
                ->description($pendingPayments > 0 ? 'Action Required' : 'All clear')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color($pendingPayments > 0 ? 'warning' : 'success')
                ->columnSpan(1),

            // Row 2: Total Attendees, Checked In, Not Checked In
            Stat::make('Total Attendees', $totalAttendees)
                ->description('Unique ticket buyers')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->columnSpan(1),

            Stat::make('Checked In', $ticketsValidated)
                ->description('Tickets validated')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->columnSpan(1),

            Stat::make('Not Checked In', $ticketsNotValidated)
                ->description('Awaiting validation')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->columnSpan(1),
        ];
    }
}
