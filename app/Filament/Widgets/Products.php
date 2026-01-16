<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Products extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Products', Product::where('is_active', true)->count())
                ->icon(Heroicon::OutlinedCube)
                ->color('primary')
                ->description('Active products'),
            Stat::make('Categories', Category::where('is_active', true)->count())
                ->icon(Heroicon::OutlinedFolder)
                ->color('secondary')
                ->description('Active categories'),
        ];
    }
}
