<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class LastVisitors extends TableWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 2;

    public function table(Table $table): Table
    {

        return $table
            ->query(fn (): Builder => Visitor::query()->orderBy('created_at', 'desc')->limit(10))
            ->columns([
                TextColumn::make('created_at')
                    ->label('Visited At')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('country_name')
                    ->label('Country')
                    ->searchable(),
                TextColumn::make('city')
                    ->label('City')
                    ->searchable(),
                TextColumn::make('device')
                    ->label('Device')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('browser')
                    ->label('Browser')
                    ->badge()
                    ->color('success'),
                TextColumn::make('os')
                    ->label('OS')
                    ->badge()
                    ->color('info'),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
