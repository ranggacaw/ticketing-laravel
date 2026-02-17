<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use App\Services\ActivityLogger;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class ManualCheckInWidget extends BaseWidget
{
    protected static ?int $sort = 8;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Ticket::query()
                    ->with(['user', 'event', 'ticketType'])
                    ->whereNull('scanned_at')
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->label('Ticket ID')
                    ->copyable()
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Attendee Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event.title')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('ticketType.name')
                    ->label('Ticket Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Purchase Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->relationship('event', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->emptyStateHeading('No pending check-ins')
            ->emptyStateDescription('All tickets have been checked in.')
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(10);
    }
}
