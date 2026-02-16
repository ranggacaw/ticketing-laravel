<?php

namespace App\Filament\Resources\Events\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'tickets';

    protected static ?string $title = 'Participants';

    protected static ?string $recordTitleAttribute = 'uuid';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('uuid')
                    ->required()
                    ->maxLength(255),
                TextInput::make('user_name')
                    ->required(),
                TextInput::make('user_email')
                    ->email()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('uuid')
            ->columns([
                TextColumn::make('user_name')
                    ->label('Guest Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user_email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->searchable(),
                TextColumn::make('ticketType.name')
                    ->label('Type')
                    ->badge(),
                TextColumn::make('seat.number')
                    ->label('Seat'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'issued' => 'success',
                        'scanned' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('scanned_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'issued' => 'Issued',
                        'scanned' => 'Scanned',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('type')
                    ->relationship('ticketType', 'name'),
            ])
            ->headerActions([
                // Usually tickets are created via checkout, not here
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(), // Maybe allow editing guest details
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
