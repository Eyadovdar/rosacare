<?php

namespace App\Filament\Resources\PositionApplications\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Schemas\Schema;

class PositionApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Position Information')
                    ->schema([
                        TextEntry::make('position.name')
                            ->label('Position')
                            ->getStateUsing(function ($record) {
                                $position = $record->position;
                                return $position->translate('en')?->name ?? $position->translate('ar')?->name ?? 'N/A';
                            }),
                    ]),
                Section::make('Applicant Information')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Full Name'),
                        TextEntry::make('email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope'),
                        TextEntry::make('phone')
                            ->label('Phone')
                            ->icon('heroicon-o-phone')
                            ->placeholder('-'),
                    ]),
                Section::make('Application Details')
                    ->schema([
                        TextEntry::make('experience')
                            ->label('Experience')
                            ->columnSpanFull()
                            ->wrap()
                            ->copyable(),
                        TextEntry::make('qualifications')
                            ->label('Qualifications')
                            ->columnSpanFull()
                            ->wrap()
                            ->copyable(),
                        TextEntry::make('cv_filename')
                            ->label('CV File')
                            ->getStateUsing(function ($record) {
                                if ($record->cv_path) {
                                    return $record->cv_filename . ' (' . 
                                        '<a href="' . $record->cv_url . '" target="_blank" class="text-primary-600 hover:underline">Download</a>)';
                                }
                                return 'No CV uploaded';
                            })
                            ->html(),
                    ]),
                Section::make('Status')
                    ->schema([
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
                            ->label('Applied At')
                            ->dateTime(),
                    ]),
            ]);
    }
}

