<?php

namespace App\Filament\Resources\Venues\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VenueInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('address'),
                TextEntry::make('city'),
                TextEntry::make('state')
                    ->placeholder('-'),
                TextEntry::make('country'),
                TextEntry::make('postal_code')
                    ->placeholder('-'),
                TextEntry::make('capacity')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
