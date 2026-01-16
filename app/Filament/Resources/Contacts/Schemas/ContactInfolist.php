<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContactInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Name'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->icon('heroicon-o-envelope'),
                TextEntry::make('phone')
                    ->label('Phone')
                    ->icon('heroicon-o-phone')
                    ->placeholder('-'),
                TextEntry::make('subject')
                    ->label('Subject')
                    ->placeholder('-'),
                TextEntry::make('message')
                    ->label('Message')
                    ->columnSpanFull()
                    ->wrap()
                    ->copyable()
                    ->placeholder('No message provided')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return 'No message provided';
                        }
                        return $state;
                    }),
                IconEntry::make('is_read')
                    ->label('Read Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextEntry::make('read_at')
                    ->label('Read At')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
