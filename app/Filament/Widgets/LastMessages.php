<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Widgets\TableWidget;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class LastMessages extends TableWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Contact::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('phone'),
                TextColumn::make('subject'),
                TextColumn::make('message')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_read')
                    ->boolean()
                    ->color(fn(Contact $record): string => $record->is_read ? 'success' : 'danger'),
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
            ->headerActions([

            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
