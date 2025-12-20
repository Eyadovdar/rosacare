<?php

namespace App\Filament\Resources\NavigationMenuItems;

use App\Filament\Resources\NavigationMenuItems\Pages\CreateNavigationMenuItem;
use App\Filament\Resources\NavigationMenuItems\Pages\EditNavigationMenuItem;
use App\Filament\Resources\NavigationMenuItems\Pages\ListNavigationMenuItems;
use App\Filament\Resources\NavigationMenuItems\Pages\ViewNavigationMenuItem;
use App\Filament\Resources\NavigationMenuItems\Schemas\NavigationMenuItemForm;
use App\Filament\Resources\NavigationMenuItems\Schemas\NavigationMenuItemInfolist;
use App\Filament\Resources\NavigationMenuItems\Tables\NavigationMenuItemsTable;
use App\Models\NavigationMenuItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NavigationMenuItemResource extends Resource
{
    protected static ?string $model = NavigationMenuItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Menu';

    public static function form(Schema $schema): Schema
    {
        return NavigationMenuItemForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NavigationMenuItemInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NavigationMenuItemsTable::configure($table);
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
            'index' => ListNavigationMenuItems::route('/'),
            'create' => CreateNavigationMenuItem::route('/create'),
            'view' => ViewNavigationMenuItem::route('/{record}'),
            'edit' => EditNavigationMenuItem::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
