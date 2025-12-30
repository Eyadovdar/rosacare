<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Non-translatable fields
                Section::make('General Information')
                    ->schema([
                        FileUpload::make('announcement_image')
                            ->label('Image')
                            ->image()
                            ->disk('public')
                            ->directory('announcements')
                            ->helperText('Image shared across all locales.'),
                        TextInput::make('button_url')
                            ->label('Button URL')
                            ->url()
                            ->helperText('Button URL shared across all locales.')
                            ->default(null),
                        TextInput::make('button_color')
                            ->label('Button Color')
                            ->helperText('Button color shared across all locales (e.g., #FF0000).')
                            ->default(null),
                        TextInput::make('button_text_color')
                            ->label('Button Text Color')
                            ->helperText('Button text color shared across all locales (e.g., #FFFFFF).')
                            ->default(null),
                    ])
                    ->columns(2),

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
