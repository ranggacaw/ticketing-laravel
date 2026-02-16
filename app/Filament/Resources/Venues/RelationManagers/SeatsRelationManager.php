<?php

namespace App\Filament\Resources\Venues\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeatsRelationManager extends RelationManager
{
    protected static string $relationship = 'seats';

    protected static ?string $recordTitleAttribute = 'number';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('section')
                    ->required()
                    ->label('Section')
                    ->maxLength(255),
                TextInput::make('row')
                    ->required()
                    ->label('Row')
                    ->maxLength(255),
                TextInput::make('number')
                    ->required()
                    ->label('Seat Number')
                    ->maxLength(255),
                Select::make('type')
                    ->options([
                        'standard' => 'Standard',
                        'vip' => 'VIP',
                        'accessible' => 'Accessible',
                    ])
                    ->required(),
                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
                        'reserved' => 'Reserved',
                    ])
                    ->default('available')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('section')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('row')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('number')
                    ->label('Seat Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'vip' => 'warning',
                        'accessible' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'unavailable' => 'danger',
                        'reserved' => 'warning',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
