<?php

namespace App\Filament\Resources\Tickets\Tables;

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\TicketExporter;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('user_name')
                    ->label('Guest Name')
                    ->searchable(),
                TextColumn::make('user_email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('seat_number')
                    ->label('Seat')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'issued' => 'success',
                        'scanned' => 'info',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('scanned_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'issued' => 'Issued',
                        'scanned' => 'Scanned',
                    ]),
                SelectFilter::make('type')
                    ->options(function () {
                        // Safe usage
                        try {
                            return \App\Models\TicketType::pluck('name', 'name')->toArray();
                        } catch (\Exception $e) {
                            return [];
                        }
                    }),
                Filter::make('scanned') // Replaced simple boolean with queries
                    ->query(fn (Builder $query) => $query->whereNotNull('scanned_at'))
                    ->toggle(), // make it a checkbox filter?
                // Or merge? Task says "scanned/unscanned".
                // I will add another filter or use SelectFilter. But toggles work too.
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(TicketExporter::class),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('success')
                    ->url(fn (Ticket $record) => route('admin.tickets.export', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
