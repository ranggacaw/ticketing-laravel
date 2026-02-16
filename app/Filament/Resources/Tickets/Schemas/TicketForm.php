<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('event_id')
                    ->relationship('event', 'name'),
                Select::make('ticket_type_id')
                    ->relationship('ticketType', 'name'),
                Select::make('seat_id')
                    ->relationship('seat', 'id'),
                TextInput::make('status')
                    ->required()
                    ->default('issued'),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                TextInput::make('user_name')
                    ->required(),
                TextInput::make('user_email')
                    ->email()
                    ->required(),
                TextInput::make('seat_number'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('type'),
                TextInput::make('payment_status')
                    ->required()
                    ->default('pending'),
                TextInput::make('barcode_data')
                    ->required(),
                DateTimePicker::make('scanned_at'),
            ]);
    }
}
