<?php

namespace App\Filament\Resources\Parallaxes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ParallaxForm
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
                            ->directory('parallaxes/images')
                            ->visibility('public')
                            ->required(),
                        TextInput::make('link')
                            ->label('Link URL')
                            ->url()
                            ->required()
                            ->default('/products'),
                        Toggle::make('is_active')
                            ->label('Is Active')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),

                // Translation Tabs for Translatable Fields
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
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
