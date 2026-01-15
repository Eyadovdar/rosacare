<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Filament\Widgets\ChartWidget;

class Countries extends ChartWidget
{
    protected ?string $heading = 'Visitors by Country';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        // Get visitors grouped by country
        $visitorsByCountry = Visitor::selectRaw('country_code, country_name, COUNT(*) as count')
            ->whereNotNull('country_code')
            ->groupBy('country_code', 'country_name')
            ->orderBy('count', 'desc')
            ->limit(10) // Show top 10 countries
            ->get();

        $labels = [];
        $data = [];

        foreach ($visitorsByCountry as $item) {
            // Use country name if available, otherwise use country code
            $label = $item->country_name ?? $item->country_code ?? 'Unknown';
            $labels[] = $label;
            $data[] = (int) $item->count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Visitors',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(231, 33, 119, 0.8)',
                        'rgba(134, 44, 145, 0.8)',
                        'rgba(121, 134, 69, 0.8)',
                        'rgba(84, 87, 89, 0.8)',
                        'rgba(189, 196, 200, 0.8)',
                        'rgba(194, 181, 130, 0.8)',
                        'rgba(231, 33, 119, 0.6)',
                        'rgba(134, 44, 145, 0.6)',
                        'rgba(121, 134, 69, 0.6)',
                        'rgba(84, 87, 89, 0.6)',
                    ],
                    'borderColor' => [
                        'rgba(231, 33, 119, 1)',
                        'rgba(134, 44, 145, 1)',
                        'rgba(121, 134, 69, 1)',
                        'rgba(84, 87, 89, 1)',
                        'rgba(189, 196, 200, 1)',
                        'rgba(194, 181, 130, 1)',
                        'rgba(231, 33, 119, 1)',
                        'rgba(134, 44, 145, 1)',
                        'rgba(121, 134, 69, 1)',
                        'rgba(84, 87, 89, 1)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
