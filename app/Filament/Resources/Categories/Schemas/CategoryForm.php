<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled(fn ($get) => filled($get('title'))),
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
            ]);
    }
}
