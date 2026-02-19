<?php

namespace App\Filament\Resources\Events\RelationManagers;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TicketTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'ticketTypes';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->label('Total Inventory'),
                TextInput::make('seat_label')
                    ->label('Seat Label')
                    ->placeholder('e.g. General Admission, VIP Row A, Block B')
                    ->helperText('This label will appear as the "Seat" on every ticket of this type.')
                    ->maxLength(100)
                    ->nullable(),
                Textarea::make('description')
                    ->columnSpanFull(),
                DateTimePicker::make('sale_start_date'),
                DateTimePicker::make('sale_end_date'),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('seat_label')
                    ->label('Seat Label')
                    ->default('General Admission')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Inventory')
                    ->sortable(),
                TextColumn::make('tickets_count')
                    ->counts('tickets')
                    ->label('Sold'),
                ToggleColumn::make('is_active')
                    ->label('Active?'),
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
