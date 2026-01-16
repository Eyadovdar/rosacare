<?php

namespace App\Filament\Resources\Welcomes;

use App\Filament\Resources\Welcomes\Pages\CreateWelcome;
use App\Filament\Resources\Welcomes\Pages\EditWelcome;
use App\Filament\Resources\Welcomes\Pages\ListWelcomes;
use App\Filament\Resources\Welcomes\Schemas\WelcomeForm;
use App\Filament\Resources\Welcomes\Tables\WelcomesTable;
use App\Models\Welcome;
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WelcomeResource extends Resource
{
    protected static ?string $model = Welcome::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHandRaised;

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'Welcome';

    public static function form(Schema $schema): Schema
    {
        return WelcomeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WelcomesTable::configure($table);
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
            'index' => ListWelcomes::route('/'),
            'create' => CreateWelcome::route('/create'),
            'edit' => EditWelcome::route('/{record}/edit'),
        ];
    }
}
