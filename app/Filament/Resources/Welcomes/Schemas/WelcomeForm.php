<?php

namespace App\Filament\Resources\Welcomes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class WelcomeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Non-translatable fields
                Section::make('General Information')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->disk('public')
                            ->directory('welcomes/images')
                            ->visibility('public')
                            ->required()
                            ->helperText('Image shared across all locales.'),
                        TextInput::make('button_url')
                            ->label('Button URL')
                            ->url()
                            ->required()
                            ->helperText('Button URL shared across all locales.'),
                    ])
                    ->columns(2),

                // Translation Tabs for Welcome
                Tabs::make('Welcome Translations')
                    ->tabs([
                        Tab::make('Arabic (ar)')
                            ->schema([
                                TextInput::make('title:ar')
                                    ->label('Title (Arabic)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description:ar')
                                    ->label('Description (Arabic)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('button_text:ar')
                                    ->label('Button Text (Arabic)')
                                    ->maxLength(255),
                            ]),
                        Tab::make('English (en)')
                            ->schema([
                                TextInput::make('title:en')
                                    ->label('Title (English)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description:en')
                                    ->label('Description (English)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('button_text:en')
                                    ->label('Button Text (English)')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),

                // Welcome Details Repeater
                Section::make('Welcome Details')
                    ->schema([
                        Repeater::make('welcomeDetails')
                            ->label('Welcome Details')
                            ->schema([
                                // Non-translatable fields
                                FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('welcomes/details')
                                    ->visibility('public')
                                    ->required(),
                                TextInput::make('button_url')
                                    ->label('Button URL')
                                    ->url()
                                    ->nullable(),
                                TextInput::make('button_color')
                                    ->label('Button Color')
                                    ->helperText('Button color (e.g., #FF0000).')
                                    ->nullable(),
                                TextInput::make('button_text_color')
                                    ->label('Button Text Color')
                                    ->helperText('Button text color (e.g., #FFFFFF).')
                                    ->nullable(),

                                // Arabic translations
                                TextInput::make('title:ar')
                                    ->label('Title (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('description:ar')
                                    ->label('Description (Arabic)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('button_text:ar')
                                    ->label('Button Text (Arabic)')
                                    ->maxLength(255),

                                // English translations
                                TextInput::make('title:en')
                                    ->label('Title (English)')
                                    ->maxLength(255),
                                Textarea::make('description:en')
                                    ->label('Description (English)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('button_text:en')
                                    ->label('Button Text (English)')
                                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title:ar'] ?? $state['title:en'] ?? 'New Detail')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
