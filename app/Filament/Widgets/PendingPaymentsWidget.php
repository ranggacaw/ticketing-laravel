<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendingPaymentsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $pendingCount = Payment::where('status', 'pending')->count();

        return [
            Stat::make('Pending Payments', $pendingCount)
                ->description($pendingCount > 0 ? 'Action Required' : 'All clear')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color($pendingCount > 0 ? 'warning' : 'success')
                ->url(route('filament.admin.resources.payments.index', ['tableFilters[status][value]' => 'pending'])),
        ];
    }
}
