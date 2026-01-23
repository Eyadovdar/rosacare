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
use UnitEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ParallaxResource extends Resource
{
    protected static ?string $model = Parallax::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Site Sections';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'link';

    public static function getGloballySearchableAttributes(): array
    {
        return ['link'];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        $query = parent::getGlobalSearchEloquentQuery()->with(['translations']);

        $search = request()->query('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('link', 'like', "%{$search}%")
                    ->orWhereHas('translations', function ($translationQuery) use ($search) {
                        $translationQuery->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $translation = $record->translate('en') ?? $record->translate('ar') ?? $record->translations->first();
        $title = $translation?->title ?? 'Parallax #' . $record->id;

        return [
            'title' => $title,
            'link' => $record->link,
        ];
    }

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
