<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Logins extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Visits', Visitor::count()),
            Stat::make('Unique Visitors', Visitor::distinct('ip_address')->count()),
            Stat::make('Total Visitors', Visitor::count()),
            Stat::make('Total Visitors', Visitor::count()),
        ];
    }
}
