<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Models\Payment;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('bank.name')
                    ->label('Bank')
                    ->sortable(),
                ImageColumn::make('payment_proof_url')
                    ->label('Proof')
                    ->circular()
                    ->height(40)
                    ->visibility('private'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Payment $record) => $record->status === 'pending')
                    ->action(function (Payment $record) {
                        DB::transaction(function () use ($record) {
                            $record->update([
                                'status' => 'confirmed',
                                'confirmed_at' => now(),
                                'confirmed_by' => auth()->id(),
                            ]);
                            // Update tickets status
                            $record->tickets()->update(['payment_status' => 'confirmed']);
                        });
                        
                        Notification::make()
                            ->title('Payment Approved')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->required(),
                    ])
                    ->visible(fn (Payment $record) => $record->status === 'pending')
                    ->action(function (Payment $record, array $data) {
                        DB::transaction(function () use ($record, $data) {
                            $record->update([
                                'status' => 'cancelled',
                                'rejection_reason' => $data['rejection_reason'],
                            ]);
                            
                            $record->tickets()->update([
                                'payment_status' => 'cancelled',
                                'status' => 'cancelled' // Cancel ticket usage
                            ]);

                            // Restore inventory
                            foreach ($record->tickets as $ticket) {
                                if ($ticket->ticketType) {
                                    $ticket->ticketType->decrement('sold');
                                }
                            }
                        });

                        Notification::make()
                            ->title('Payment Rejected')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('approve_bulk')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status !== 'pending') continue;
                                
                                DB::transaction(function () use ($record) {
                                    $record->update([
                                        'status' => 'confirmed',
                                        'confirmed_at' => now(),
                                        'confirmed_by' => auth()->id(),
                                    ]);
                                    $record->tickets()->update(['payment_status' => 'confirmed']);
                                });
                                $count++;
                            }

                            Notification::make()
                                ->title("$count Payments Approved")
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }
}
