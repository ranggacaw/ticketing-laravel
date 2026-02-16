<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 2; // Order below stats

    public function table(Table $table): Table
    {
        return $table
            ->query(ActivityLog::query()->latest()->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->placeholder('System')
                    ->sortable(),
                Tables\Columns\TextColumn::make('action')
                    ->badge()
                    ->colors(['primary']),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Time')
                    ->sortable()
                    ->since(),
            ])
            ->paginated(false);
    }
}
