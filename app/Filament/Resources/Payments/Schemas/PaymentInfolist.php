<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('invoice_number'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('payment_proof_url')
                    ->label('Payment Proof (Link)')
                    ->formatStateUsing(fn ($state) => $state ? 'View Proof (' . strtoupper(pathinfo($state, PATHINFO_EXTENSION)) . ')' : 'No Proof')
                    ->icon('heroicon-m-document-text')
                    ->url(fn ($record) => $record->payment_proof_url ? asset('storage/' . $record->payment_proof_url) : null)
                    ->openUrlInNewTab()
                    ->color('primary'),
                ImageEntry::make('payment_proof_url')
                    ->label('Payment Proof')
                    ->visible(fn ($record) => $record->payment_proof_url && in_array(strtolower(pathinfo($record->payment_proof_url, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'svg']))
                    ->disk('public'),
                TextEntry::make('confirmed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('confirmed_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('bank.name')
                    ->label('Bank')
                    ->placeholder('-'),
                TextEntry::make('sender_account_name')
                    ->placeholder('-'),
                TextEntry::make('sender_account_number')
                    ->placeholder('-'),
                TextEntry::make('rejection_reason')
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }
}
