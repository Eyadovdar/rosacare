<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('sku')
                            ->label('SKU')
                            ->unique(ignoreRecord: true)
                            ->nullable(),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->nullable(),
                        TextInput::make('sale_price')
                            ->numeric()
                            ->prefix('$')
                            ->nullable(),
                        TextInput::make('stock_quantity')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('in_stock')
                            ->default(true)
                            ->required(),
                        Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                        Toggle::make('is_featured')
                            ->default(false)
                            ->required(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('view_count')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->disabled(),
                        Textarea::make('specifications')
                            ->rows(3)
                            ->columnSpanFull(),
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
                                Textarea::make('short_description:ar')
                                    ->label('Short Description (Arabic)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Textarea::make('description:ar')
                                    ->label('Description (Arabic)')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                Repeater::make('ingredients:ar')
                                    ->label('Ingredients (Arabic)')
                                    ->schema([
                                        TextInput::make('item')
                                            ->required(),
                                    ])
                                    ->defaultItems(0)
                                    ->columnSpanFull(),
                                Repeater::make('benefits:ar')
                                    ->label('Benefits (Arabic)')
                                    ->schema([
                                        TextInput::make('item')
                                            ->required(),
                                    ])
                                    ->defaultItems(0)
                                    ->columnSpanFull(),
                                Repeater::make('usage_instructions:ar')
                                    ->label('Usage Instructions (Arabic)')
                                    ->schema([
                                        TextInput::make('item')
                                            ->required(),
                                    ])
                                    ->defaultItems(0)
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
                                Textarea::make('short_description:en')
                                    ->label('Short Description (English)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Textarea::make('description:en')
                                    ->label('Description (English)')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                Repeater::make('ingredients:en')
                                    ->label('Ingredients (English)')
                                    ->schema([
                                        TextInput::make('item')
                                            ->required(),
                                    ])
                                    ->defaultItems(0)
                                    ->columnSpanFull(),
                                Repeater::make('benefits:en')
                                    ->label('Benefits (English)')
                                    ->schema([
                                        TextInput::make('item')
                                            ->required(),
                                    ])
                                    ->defaultItems(0)
                                    ->columnSpanFull(),
                                Repeater::make('usage_instructions:en')
                                    ->label('Usage Instructions (English)')
                                    ->schema([
                                        TextInput::make('item')
                                            ->required(),
                                    ])
                                    ->defaultItems(0)
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
