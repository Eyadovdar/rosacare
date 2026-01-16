<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Carbon\Carbon;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Logins extends StatsOverviewWidget
{
    protected static ?int $sort = 3;
    protected function getStats(): array
    {
        $totalVisitors = Visitor::count();

        // Calculate daily average
        $firstVisitor = Visitor::orderBy('created_at', 'asc')->first();
        $dailyAverage = 0;

        if ($firstVisitor) {
            $firstDate = Carbon::parse($firstVisitor->created_at);
            $daysDiff = $firstDate->diffInDays(now());

            // If there's at least one day difference, calculate average
            // Otherwise, if visitors exist but all on same day, use 1 day
            $days = max($daysDiff, 1);
            $dailyAverage = round($totalVisitors / $days, 2);
        }

        return [
            Stat::make('Visits', Visitor::count())
                ->icon(Heroicon::OutlinedEye)
                ->color('primary')
                ->description('Total page visits'),
            Stat::make('Unique Visitors', Visitor::distinct('ip_address')->count())
                ->icon(Heroicon::OutlinedUserGroup)
                ->color('secondary')
                ->description('Distinct IP addresses'),
            Stat::make('Daily Average', $dailyAverage)
                ->icon(Heroicon::OutlinedCalendar)
                ->color('success')
                ->description('Visitors per day'),
            Stat::make('Total Visitors', Visitor::count())
                ->icon(Heroicon::OutlinedGlobeAlt)
                ->color('warning')
                ->description('All visitor records'),
        ];
    }
}
