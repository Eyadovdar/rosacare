<?php

namespace App\Filament\Resources\Policies\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;

class PolicyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Select::make('locale')
                    ->required()
                    ->default('en')
                    ->options([
                        'en' => 'English',
                        'ar' => 'العربية',
                    ]),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
