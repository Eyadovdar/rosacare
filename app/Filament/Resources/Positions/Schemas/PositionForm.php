<?php

namespace App\Filament\Resources\Positions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput as TextInputComponent;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
                Toggle::make('is_featured')
                    ->label('Featured (Show on Homepage)')
                    ->default(false),
                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0),
                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('positions/images')
                    ->visibility('public')
                    ->helperText('Image shared across all locales.'),
                TextInput::make('button_url')
                    ->label('Button URL')
                    ->url()
                    ->nullable(),
                ColorPicker::make('button_color')
                    ->label('Button Color')
                    ->nullable(),
                ColorPicker::make('button_text_color')
                    ->label('Button Text Color')
                    ->nullable(),
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic (ar)')
                            ->schema([
                                TextInput::make('name:ar')
                                    ->label('Position Name (Arabic)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description:ar')
                                    ->label('Description (Arabic)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Textarea::make('qualifications:ar')
                                    ->label('Qualifications (Arabic)')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                Textarea::make('responsibilities:ar')
                                    ->label('Responsibilities (Arabic)')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                TextInput::make('button_text:ar')
                                    ->label('Button Text (Arabic)')
                                    ->maxLength(255),
                            ]),
                        Tab::make('English (en)')
                            ->schema([
                                TextInput::make('name:en')
                                    ->label('Position Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description:en')
                                    ->label('Description (English)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Textarea::make('qualifications:en')
                                    ->label('Qualifications (English)')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                Textarea::make('responsibilities:en')
                                    ->label('Responsibilities (English)')
                                    ->rows(5)
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

