<?php

namespace App\Filament\Resources\Welcomes\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\ColorPicker;

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
                            ->maxSize(10240) // 10MB max file size
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '21:9',
                            ])
                            ->helperText('Image shared across all locales. Recommended size: 1920x1080px (16:9 aspect ratio). Images will be automatically resized and optimized for best quality.'),
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
                                    ->required()
                                    ->maxSize(10240) // 10MB max file size
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                        '4:3',
                                        '16:9',
                                    ])
                                    ->helperText('Recommended size: 1200x1200px (1:1) or 1200x800px (3:2). Images will be automatically resized and optimized for best performance.'),
                                TextInput::make('button_url')
                                    ->label('Button URL')
                                    ->nullable(),
                                ColorPicker::make('button_color')
                                    ->label('Button Color')
                                    ->nullable(),
                                ColorPicker::make('button_text_color')
                                    ->label('Button Text Color')
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
                            ->itemLabel(fn(array $state): ?string => $state['title:ar'] ?? $state['title:en'] ?? 'New Detail')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
