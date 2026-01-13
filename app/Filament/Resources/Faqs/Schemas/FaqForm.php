<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('locale')
                    ->label('Language')
                    ->options([
                        'ar' => 'Arabic (العربية)',
                        'en' => 'English',
                    ])
                    ->required()
                    ->default('ar'),
                TextInput::make('question')
                    ->label('Question')
                    ->required()
                    ->maxLength(255),
                Textarea::make('answer')
                    ->label('Answer')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
