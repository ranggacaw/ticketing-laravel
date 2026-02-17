<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RealTimeAttendanceWidget extends BaseWidget
{
    protected static ?int $sort = 7;
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $totalTickets = Ticket::count();
        $checkedIn = Ticket::whereNotNull('scanned_at')->count();
        $notCheckedIn = Ticket::whereNull('scanned_at')->count();
        $checkInRate = $totalTickets > 0 ? round(($checkedIn / $totalTickets) * 100, 1) : 0;

        return [
            Stat::make('Total Attendees', $totalTickets)
                ->description('Ticket holders')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([7, 12, 10, 14, 15, 18, $totalTickets]),

            Stat::make('Checked In', $checkedIn)
                ->description($checkInRate . '% attendance rate')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Not Checked In', $notCheckedIn)
                ->description('Pending check-in')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
