<?php

namespace App\Filament\Resources\Heroes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class HeroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Non-translatable fields
                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('heroes/images')
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
                ColorPicker::make('button_color')
                    ->label('Button Color')
                    ->helperText('Button color shared across all locales (e.g., #FF0000).')
                    ->required(),
                ColorPicker::make('button_text_color')
                    ->label('Button Text Color')
                    ->helperText('Button text color shared across all locales (e.g., #FFFFFF).')
                    ->required(),

                // Translation Tabs
                Tabs::make('Translations')
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
            ]);
    }
}
