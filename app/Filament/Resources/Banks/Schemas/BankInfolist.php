<?php

namespace App\Filament\Resources\Banks\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BankInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('code'),
                ImageEntry::make('logo_url')
                    ->label('Logo')
                    ->placeholder('-'),
                TextEntry::make('account_name'),
                TextEntry::make('account_number'),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
