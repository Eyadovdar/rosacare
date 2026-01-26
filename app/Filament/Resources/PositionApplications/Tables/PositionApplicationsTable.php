<?php

namespace App\Filament\Resources\PositionApplications\Tables;

use App\Models\PositionApplication;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class PositionApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('position.name')
                    ->label('Position')
                    ->getStateUsing(function ($record) {
                        $position = $record->position;
                        return $position->translate('en')?->name ?? $position->translate('ar')?->name ?? 'N/A';
                    })
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('position.translations', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Applicant Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->placeholder('-'),
                IconColumn::make('is_read')
                    ->label('Read')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('created_at')
                    ->label('Applied At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('download_cv')
                    ->label('Download CV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn (PositionApplication $record): string => route('position-applications.download-cv', $record->id))
                    ->openUrlInNewTab()
                    ->visible(fn (PositionApplication $record): bool => !empty($record->cv_path)),
            ])
            ->bulkActions([
                BulkAction::make('download_cvs')
                    ->label('Download CVs (ZIP)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        $ids = $records->pluck('id')->toArray();
                        $idsParam = implode(',', $ids);
                        
                        // Redirect to download route with IDs as query parameter
                        return redirect()->route('position-applications.download-cvs-zip', ['ids' => $idsParam]);
                    })
                    ->deselectRecordsAfterCompletion(),
                RestoreBulkAction::make(),
                ForceDeleteBulkAction::make(),
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
