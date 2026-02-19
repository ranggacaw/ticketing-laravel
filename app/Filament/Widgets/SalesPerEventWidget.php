<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Number;

class SalesPerEventWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()
                    ->withCount('tickets')
                    ->withSum('tickets as revenue', 'price')
                    ->withCount(['tickets as tickets_validated' => fn($q) => $q->whereNotNull('scanned_at')])
                    ->orderByDesc('tickets_count')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Event Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('venue.name')
                    ->label('Venue')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tickets_count')
                    ->label('Tickets Sold')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('tickets_validated')
                    ->label('Tickets Validated')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('revenue')
                    ->label('Revenue')
                    ->formatStateUsing(fn($state) => Number::idr($state))
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Event Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
