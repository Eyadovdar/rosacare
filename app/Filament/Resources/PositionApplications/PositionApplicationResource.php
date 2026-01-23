<?php

namespace App\Filament\Resources\PositionApplications;

use App\Filament\Resources\PositionApplications\Pages\ListPositionApplications;
use App\Filament\Resources\PositionApplications\Pages\ViewPositionApplication;
use App\Filament\Resources\PositionApplications\Schemas\PositionApplicationInfolist;
use App\Filament\Resources\PositionApplications\Tables\PositionApplicationsTable;
use App\Models\PositionApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PositionApplicationResource extends Resource
{
    protected static ?string $model = PositionApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Support';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function infolist(Schema $schema): Schema
    {
        return PositionApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PositionApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPositionApplications::route('/'),
            'view' => ViewPositionApplication::route('/{record}'),
        ];
    }
}

