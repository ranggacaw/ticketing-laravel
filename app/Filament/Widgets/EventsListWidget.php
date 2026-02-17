<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class EventsListWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Event::query()->with(['organizer', 'venue'])->latest())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Event Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('venue.name')
                    ->label('Venue')
                    ->sortable(),
                Tables\Columns\TextColumn::make('organizer.name')
                    ->label('Organizer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'published',
                        'warning' => 'draft',
                    ]),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Start Time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('End Time')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
