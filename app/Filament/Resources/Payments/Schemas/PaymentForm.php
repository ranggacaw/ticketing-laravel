<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('invoice_number')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled'])
                    ->default('pending')
                    ->required(),
                TextInput::make('payment_proof_url')
                    ->url(),
                DateTimePicker::make('confirmed_at'),
                TextInput::make('confirmed_by')
                    ->numeric(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Select::make('bank_id')
                    ->relationship('bank', 'name'),
                TextInput::make('sender_account_name'),
                TextInput::make('sender_account_number'),
                Textarea::make('rejection_reason')
                    ->columnSpanFull(),
            ]);
    }
}
