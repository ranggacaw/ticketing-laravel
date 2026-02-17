<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class BuyersAttendeesWidget extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Ticket::query()
                    ->with(['user', 'event', 'ticketType'])
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Buyer Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('event.title')
                    ->label('Event')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ticketType.name')
                    ->label('Ticket Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('uuid')
                    ->label('Ticket ID')
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'issued' => 'primary',
                        'scanned' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('scanned_at')
                    ->label('Checked In At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Purchased At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->relationship('event', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'issued' => 'Issued',
                        'scanned' => 'Scanned/Checked In',
                    ]),
            ])
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(10);
    }
}
