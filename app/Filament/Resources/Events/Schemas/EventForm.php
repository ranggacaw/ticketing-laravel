<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                RichEditor::make('description')
                    ->columnSpanFull(),
                FileUpload::make('banner')
                    ->image()
                    ->disk('public')
                    ->directory('event-banners')
                    ->visibility('public'),
                Section::make('Location Details')
                    ->schema([
                        TextInput::make('location')
                            ->maxLength(255),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('latitude')
                                    ->id('latitude-input')
                                    ->numeric()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        // Logic to update map if needed, or map updates this
                                    }),
                                TextInput::make('longitude')
                                    ->id('longitude-input')
                                    ->numeric()
                                    ->required()
                                    ->live(),
                            ]),
                        ViewField::make('map_location')
                            ->view('filament.forms.components.map-picker')
                            ->columnSpanFull(),
                    ]),
                Select::make('venue_id')
                    ->relationship('venue', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('address')
                            ->required(),
                        TextInput::make('city')
                            ->required(),
                        TextInput::make('state'),
                        TextInput::make('country')
                            ->required(),
                        TextInput::make('postal_code'),
                        TextInput::make('capacity')
                            ->numeric(),
                    ])
                    ->required(),
                Select::make('organizer_id')
                    ->relationship('organizer', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('status')
                    ->options([
                        'published' => 'Published',
                        'draft' => 'Draft',
                        'archived' => 'Archived',
                    ])
                    ->required()
                    ->default('draft'),
                DateTimePicker::make('start_time')
                    ->required(),
                DateTimePicker::make('end_time')
                    ->required()
                    ->after('start_time'),
            ]);
    }
}
