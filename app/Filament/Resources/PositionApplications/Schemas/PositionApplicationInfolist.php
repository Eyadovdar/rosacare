<?php

namespace App\Filament\Resources\PositionApplications\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PositionApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // Header Section - Compact Report Style
                TextEntry::make('Job Application Report')
                    ->label('_')
                    ->getStateUsing(function ($record) {
                        $position = $record->position;
                        $positionName = $position->translate('en')?->name ?? $position->translate('ar')?->name ?? 'N/A';
                        return '<div style="border-bottom: 2px solid #e72177; padding-bottom: 10px; margin-bottom: 15px;">
                                    <h2 style="color: #e72177; font-size: 20px; font-weight: bold; margin: 0;">Job Application Report</h2>
                                    <p style="color: #6b7280; font-size: 12px; margin: 3px 0 0 0;">Application ID: #' . $record->id . ' | Submitted: ' . $record->created_at->format('M j, Y g:i A') . '</p>
                                </div>';
                    })
                    ->html()
                    ->columnSpanFull(),

                // Left Column: Position Information
                TextEntry::make('position.name')
                    ->label('Position Applied For')
                    ->getStateUsing(function ($record) {
                        $position = $record->position;
                        return $position->translate('en')?->name ?? $position->translate('ar')?->name ?? 'N/A';
                    })
                    ->weight('bold')
                    ->size('sm')
                    ->columnSpan(1),

                // Right Column: Contact Information - Name
                TextEntry::make('name')
                    ->label('Full Name')
                    ->weight('bold')
                    ->size('sm')
                    ->columnSpan(1),

                // Left Column: Application Date
                TextEntry::make('created_at')
                    ->label('Application Date')
                    ->dateTime('M j, Y g:i A')
                    ->icon('heroicon-o-calendar')
                    ->size('sm')
                    ->columnSpan(1),

                // Right Column: Email
                TextEntry::make('email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->size('sm')
                    ->columnSpan(1),

                // Left Column: Verification Status
                IconEntry::make('is_verified')
                    ->label('Verification')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->getStateUsing(fn ($record) => $record->is_verified)
                    ->columnSpan(1),

                // Right Column: Phone
                TextEntry::make('phone')
                    ->label('Phone')
                    ->icon('heroicon-o-phone')
                    ->placeholder('Not provided')
                    ->size('sm')
                    ->columnSpan(1),

                // Experience
                TextEntry::make('experience')
                    ->label('Experience')
                    ->wrap()
                    ->copyable()
                    ->markdown()
                    ->placeholder('No experience provided')
                    ->columnSpanFull(),

                // Qualifications
                TextEntry::make('qualifications')
                    ->label('Qualifications')
                    ->wrap()
                    ->copyable()
                    ->markdown()
                    ->placeholder('No qualifications provided')
                    ->columnSpanFull(),

                // CV Document
                TextEntry::make('cv_filename')
                    ->label('CV Document')
                    ->getStateUsing(function ($record) {
                        if ($record->cv_path) {
                            return '<div style="padding: 8px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 4px; display: inline-flex; align-items: center; gap: 8px;">
                                        <span style="color: #374151; font-weight: 500; font-size: 13px;">' . htmlspecialchars($record->cv_filename) . '</span>
                                        <a href="' . $record->cv_url . '" target="_blank"
                                           style="color: #e72177; text-decoration: underline; font-weight: 500; font-size: 13px;">
                                            Download
                                        </a>
                                    </div>';
                        }
                        return '<span style="color: #9ca3af; font-size: 13px;">No CV uploaded</span>';
                    })
                    ->html()
                    ->columnSpanFull(),

                // Read Status
                IconEntry::make('is_read')
                    ->label('Read Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->columnSpan(1),

                // Read At
                TextEntry::make('read_at')
                    ->label('Read At')
                    ->dateTime('M j, Y g:i A')
                    ->placeholder('Not read yet')
                    ->icon('heroicon-o-clock')
                    ->size('sm')
                    ->columnSpan(1),
            ]);
    }
}

