<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\Builder;

/**
 * Helper class to generate Builder blocks configuration
 * This allows us to reuse the same block definitions for multiple locales
 */
class PageFormHelper
{
    public static function getBuilderBlocks(): array
    {
        return [
            // Standard Reusable Blocks
            Builder\Block::make('paragraph')
                ->label('Paragraph')
                ->icon('heroicon-o-bars-3-bottom-left')
                ->schema([
                    \Filament\Forms\Components\RichEditor::make('text')
                        ->label('Text Content')
                        ->helperText('Locale-specific content.')
                        ->required()
                        ->columnSpanFull(),
                ]),
            Builder\Block::make('subheading')
                ->label('Subheading')
                ->icon('heroicon-o-chevron-double-down')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('text')
                        ->label('Subheading Text')
                        ->helperText('Locale-specific text.')
                        ->required(),
                    \Filament\Forms\Components\Select::make('level')
                        ->label('Heading Level')
                        ->options(['h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'])
                        ->default('h2')
                        ->required(),
                ]),
            // Add other blocks here as needed - this is a simplified version
            // You can copy all blocks from PageForm.php
        ];
    }
}

