<?php

namespace App\Filament\Resources\Venues\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VenueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('description')
                    ->columnSpanFull(),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                TextInput::make('state')
                    ->maxLength(255),
                TextInput::make('country')
                    ->required()
                    ->maxLength(255),
                TextInput::make('postal_code')
                    ->maxLength(255),
                TextInput::make('capacity')
                    ->numeric()
                    ->required(),
            ]);
    }
}
