<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class Visitors extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'Visitors';

    protected int | string | array $columnSpan = 1;

    public ?string $filter = 'week';

    protected function getFilters(): ?array
    {
        return [
            'week' => 'This Week',
            'month' => 'This Month',
            'all' => 'All Visits by Month',
        ];
    }

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        switch ($this->filter) {
            case 'week':
                // Get visitors for this week, grouped by day
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();

                // Get all visitors for the week in a single query
                $visitors = Visitor::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->get()
                    ->groupBy(function ($visitor) {
                        return Carbon::parse($visitor->created_at)->format('Y-m-d');
                    });

                // Create array for all 7 days of the week
                for ($i = 0; $i < 7; $i++) {
                    $date = $startOfWeek->copy()->addDays($i);
                    $dateKey = $date->format('Y-m-d');
                    $dayLabel = $date->format('D'); // Mon, Tue, etc.
                    $count = $visitors->get($dateKey) ? $visitors->get($dateKey)->count() : 0;
                    $labels[] = $dayLabel;
                    $data[] = $count;
                }
                break;

            case 'month':
                // Get visitors for this month, grouped by day
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();

                // Get all visitors for the month in a single query
                $visitors = Visitor::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->get()
                    ->groupBy(function ($visitor) {
                        return Carbon::parse($visitor->created_at)->format('Y-m-d');
                    });

                $daysInMonth = $startOfMonth->copy()->daysInMonth;
                for ($i = 0; $i < $daysInMonth; $i++) {
                    $date = $startOfMonth->copy()->addDays($i);
                    // Only include days up to today
                    if ($date->isFuture()) {
                        break;
                    }
                    $dateKey = $date->format('Y-m-d');
                    $dayLabel = $date->format('M d'); // Jan 01, Jan 02, etc.
                    $count = $visitors->get($dateKey) ? $visitors->get($dateKey)->count() : 0;
                    $labels[] = $dayLabel;
                    $data[] = $count;
                }
                break;

            case 'all':
            default:
                // Get all visitors grouped by month
                // Using DATE() function for better database compatibility
                $visitorsByMonth = Visitor::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                    ->groupBy('month')
                    ->orderBy('month', 'asc')
                    ->get();

                foreach ($visitorsByMonth as $item) {
                    $date = Carbon::createFromFormat('Y-m', $item->month);
                    $labels[] = $date->format('M Y'); // Jan 2024, Feb 2024, etc.
                    $data[] = (int) $item->count;
                }
                break;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Visitors',
                    'data' => $data,
                    'backgroundColor' => 'rgba(231, 33, 119, 0.1)',
                    'borderColor' => 'rgba(231, 33, 119, 1)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
