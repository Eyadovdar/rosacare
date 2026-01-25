<?php

namespace App\Filament\Resources\Positions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PositionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->getStateUsing(fn ($record) => $record->image_url),
                TextColumn::make('name')
                    ->label('Name (English)')
                    ->getStateUsing(function ($record) {
                        return $record->translate('en')?->name ?? $record->translate('ar')?->name ?? '-';
                    })
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('translations', function ($q) use ($search) {
                            $q->where('locale', 'en')
                                ->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Active'),
                ToggleColumn::make('is_featured')
                    ->label('Featured'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }
}

