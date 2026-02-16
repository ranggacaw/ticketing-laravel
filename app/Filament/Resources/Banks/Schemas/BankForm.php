<?php

namespace App\Filament\Resources\Banks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class BankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('logo_url')
                    ->image()
                    ->directory('banks'),
                TextInput::make('account_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('account_number')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
