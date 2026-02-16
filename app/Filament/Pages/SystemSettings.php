<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SystemSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settings';

    protected static string|\UnitEnum|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 1;

    public function getTitle(): string
    {
        return 'System Settings';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('System Settings')
                    ->description('System configuration and settings will appear here.'),
            ]);
    }
}
