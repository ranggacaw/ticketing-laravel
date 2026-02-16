<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class SystemSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settings';

    protected static string|\UnitEnum|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 1;

    public function getView(): string
    {
        return 'filament.pages.system-settings';
    }
}
