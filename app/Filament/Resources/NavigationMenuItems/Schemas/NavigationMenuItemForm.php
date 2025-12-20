<?php

namespace App\Filament\Resources\NavigationMenuItems\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NavigationMenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        Select::make('type')
                            ->options([
                                'link' => 'Custom Link',
                                'category' => 'Category',
                                'page' => 'Page',
                            ])
                            ->required()
                            ->native(false),
                        TextInput::make('url')
                            ->label('URL')
                            ->visible(fn ($get) => $get('type') === 'link')
                            ->required(fn ($get) => $get('type') === 'link'),
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->visible(fn ($get) => $get('type') === 'category')
                            ->required(fn ($get) => $get('type') === 'category')
                            ->searchable()
                            ->preload(),
                        Select::make('page')
                            ->label('Page')
                            ->options([
                                'home' => 'Home',
                                'about' => 'About',
                                'contact' => 'Contact',
                                'products' => 'Products',
                            ])
                            ->visible(fn ($get) => $get('type') === 'page')
                            ->required(fn ($get) => $get('type') === 'page')
                            ->native(false),
                        TextInput::make('icon')
                            ->label('Icon')
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
                        Toggle::make('open_in_new_tab')
                            ->label('Open in New Tab')
                            ->default(false)
                            ->required(),
                    ])
                    ->columns(2),

                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic (ar)')
                            ->schema([
                                TextInput::make('label:ar')
                                    ->label('Label (Arabic)')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Tab::make('English (en)')
                            ->schema([
                                TextInput::make('label:en')
                                    ->label('Label (English)')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
