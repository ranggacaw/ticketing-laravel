<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesTimelineChartWidget extends ChartWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $salesData = Ticket::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as tickets_sold'),
            DB::raw('SUM(price) as revenue')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Tickets Sold',
                    'data' => $salesData->pluck('tickets_sold')->toArray(),
                    'borderColor' => 'rgb(79, 70, 229)',
                    'backgroundColor' => 'rgba(79, 70, 229, 0.1)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
                [
                    'label' => 'Revenue (IDR)',
                    'data' => $salesData->pluck('revenue')->map(fn ($val) => $val / 1000000)->toArray(),
                    'borderColor' => 'rgb(16, 185, 129)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.3,
                    'fill' => true,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $salesData->pluck('date')->map(fn ($date) => \Carbon\Carbon::parse($date)->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Tickets',
                    ],
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Revenue (Millions IDR)',
                    ],
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
        ];
    }
}
