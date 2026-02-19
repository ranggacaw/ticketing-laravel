<?php

namespace App\Filament\Resources\Events\RelationManagers;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Number;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

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
                    ->prefix('IDR')
                    ->required(),
                TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->label('Total Seats / Inventory'),

                // ── Seat Configuration ──────────────────────────────────────
                Section::make('Seat Configuration')
                    ->description('Choose ONE mode: Auto-Numbered seats OR a Static label. If both are filled, Auto-Numbered takes priority.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('seat_prefix')
                                    ->label('🔢 Auto-Numbered Prefix (Recommended)')
                                    ->placeholder('e.g.  A  or  VIP-  or  B')
                                    ->helperText('Seats are assigned automatically in order: A1, A2, A3 … up to your inventory. Leave blank to use a static label instead.')
                                    ->maxLength(20)
                                    ->nullable()
                                    ->live(),
                                TextInput::make('seat_label')
                                    ->label('🏷️ Static Label (fallback)')
                                    ->placeholder('e.g. General Admission')
                                    ->helperText('Used only when no prefix is set. All tickets of this type will show the same label.')
                                    ->maxLength(100)
                                    ->nullable()
                                    ->disabled(fn($get) => !empty($get('seat_prefix'))),
                            ]),
                    ]),

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

                // Shows seat_prefix if set, else seat_label, else 'General Admission'
                TextColumn::make('seat_prefix')
                    ->label('Seat Mode')
                    ->formatStateUsing(function ($state, $record) {
                        if (!empty($record->seat_prefix)) {
                            $max = $record->quantity;
                            return strtoupper(trim($record->seat_prefix)) . '1 → '
                                . strtoupper(trim($record->seat_prefix)) . $max
                                . ' (auto)';
                        }
                        return $record->seat_label ?: 'General Admission';
                    })
                    ->badge()
                    ->color(fn($record) => !empty($record->seat_prefix) ? 'success' : 'gray'),

                TextColumn::make('sold')
                    ->label('Assigned')
                    ->formatStateUsing(fn($state, $record) => $state . ' / ' . $record->quantity)
                    ->sortable(),

                TextColumn::make('price')
                    ->formatStateUsing(fn($state) => Number::idr($state))
                    ->sortable(),

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
