<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('icon')
                            ->label('Icon')
                            ->nullable(),
                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->directory('categories')
                            ->nullable(),
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Is Active')
                            ->default(true)
                            ->required(),
                        Toggle::make('is_featured')
                            ->label('Is Featured')
                            ->default(false)
                            ->required(),
                    ])
                    ->columns(2),

                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic (ar)')
                            ->schema([
                                TextInput::make('name:ar')
                                    ->label('Name (Arabic)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description:ar')
                                    ->label('Description (Arabic)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('meta_title:ar')
                                    ->label('Meta Title (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('meta_description:ar')
                                    ->label('Meta Description (Arabic)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('meta_keywords:ar')
                                    ->label('Meta Keywords (Arabic)')
                                    ->maxLength(255),
                            ]),
                        Tab::make('English (en)')
                            ->schema([
                                TextInput::make('name:en')
                                    ->label('Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description:en')
                                    ->label('Description (English)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('meta_title:en')
                                    ->label('Meta Title (English)')
                                    ->maxLength(255),
                                Textarea::make('meta_description:en')
                                    ->label('Meta Description (English)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('meta_keywords:en')
                                    ->label('Meta Keywords (English)')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
