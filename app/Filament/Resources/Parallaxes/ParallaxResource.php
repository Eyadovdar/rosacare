<?php

namespace App\Filament\Resources\Parallaxes;

use App\Filament\Resources\Parallaxes\Pages\CreateParallax;
use App\Filament\Resources\Parallaxes\Pages\EditParallax;
use App\Filament\Resources\Parallaxes\Pages\ListParallaxes;
use App\Filament\Resources\Parallaxes\Schemas\ParallaxForm;
use App\Filament\Resources\Parallaxes\Tables\ParallaxesTable;
use App\Models\Parallax;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParallaxResource extends Resource
{
    protected static ?string $model = Parallax::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Parallax';

    public static function form(Schema $schema): Schema
    {
        return ParallaxForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParallaxesTable::configure($table);
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
            'index' => ListParallaxes::route('/'),
            'create' => CreateParallax::route('/create'),
            'edit' => EditParallax::route('/{record}/edit'),
        ];
    }
}
