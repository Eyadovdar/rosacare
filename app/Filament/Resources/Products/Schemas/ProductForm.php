<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
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
                            ->label('Category')
                            ->options(function () {
                                return Category::query()
                                    ->whereNull('deleted_at')
                                    ->get()
                                    ->sortBy('name')
                                    ->mapWithKeys(function ($category) {
                                        return [$category->id => $category->name];
                                    })
                                    ->toArray();
                            })
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

                Section::make('Images')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Main Image')
                            ->image()
                            ->disk('public')
                            ->directory('products/featured')
                            ->visibility('public')
                            ->maxSize(10240) // 10MB max file size
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->helperText('Upload the main featured image for this product. Recommended size: 1200x1200px (1:1) or 1200x800px (3:2). Images will be automatically resized and optimized for best performance.')
                            ->columnSpanFull(),
                        FileUpload::make('gallery_images')
                            ->label('Gallery Images')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('products/gallery')
                            ->visibility('public')
                            ->maxSize(10240) // 10MB max file size
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->helperText('Upload multiple images for the product gallery. Recommended size: 1200x1200px (1:1) or 1200x800px (3:2). Images will be automatically resized and optimized for best performance.')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

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
