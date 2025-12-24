<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('type')
                    ->required()
                    ->default(null),
                TextInput::make('url')
                    ->label('URL')
                    ->default(null),
                Select::make('icon')
                    ->label('Icon')
                    ->options(self::getHeroiconOptions())
                    ->searchable()
                    ->preload()
                    ->getOptionLabelUsing(fn (string $value): string => self::getHeroiconOptionLabel($value))
                    ->nullable(),
                Select::make('category_id')
                    ->relationship('category', 'title')
                    ->default(null),
                TextInput::make('page')
                    ->default(null),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('open_in_new_tab')
                    ->required(),
            ]);
    }

    /**
     * Get all available Heroicon options with their names.
     *
     * @return array<string, string>
     */
    protected static function getHeroiconOptions(): array
    {
        $options = [];

        foreach (Heroicon::cases() as $icon) {
            $value = $icon->value;
            $options[$value] = $value;
        }

        // Sort alphabetically by value
        asort($options);

        return $options;
    }

    /**
     * Get the label for a Heroicon option with icon display.
     *
     * @return string HTML string with icon and name
     */
    protected static function getHeroiconOptionLabel(string $value): string
    {
        return view('filament.forms.components.icon-option', ['value' => $value])->render();
    }
}
