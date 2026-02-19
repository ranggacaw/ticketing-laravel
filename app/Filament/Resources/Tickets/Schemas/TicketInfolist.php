<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Number;

class TicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('event.name')
                    ->label('Event')
                    ->placeholder('-'),
                TextEntry::make('ticketType.name')
                    ->label('Ticket type')
                    ->placeholder('-'),
                TextEntry::make('seat.id')
                    ->label('Seat')
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('user.name')
                    ->label('User')
                    ->placeholder('-'),
                TextEntry::make('uuid')
                    ->label('UUID'),
                TextEntry::make('user_name'),
                TextEntry::make('user_email'),
                TextEntry::make('seat_number')
                    ->placeholder('-'),
                TextEntry::make('price')
                    ->formatStateUsing(fn($state) => Number::idr($state)),
                TextEntry::make('type')
                    ->placeholder('-'),
                TextEntry::make('payment_status'),
                TextEntry::make('barcode_data'),
                TextEntry::make('scanned_at')
                    ->dateTime()
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
