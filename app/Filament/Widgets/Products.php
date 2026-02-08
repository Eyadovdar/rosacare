<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\HtmlString;

class Products extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $allStats = [
            Stat::make('Products', Product::where('is_active', true)->count())
                ->icon(Heroicon::OutlinedCube)
                ->color('success')
                ->description('Active products'),
            Stat::make('Categories', Category::where('is_active', true)->count())
                ->icon(Heroicon::OutlinedFolder)
                ->color('success')
                ->description('Active categories'),
            Stat::make('Messages', Contact::where('is_read', false)->count())
                ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                ->color('info')
                ->description('Unread messages'),
        ];

        $topThreeViewed = Product::with('featuredImage')->orderByDesc('view_count')->take(3)->get();
        // $rankDescriptions = ['Most viewed', '2nd most viewed', '3rd most viewed'];

        $topThreeStats = [];
        foreach ($topThreeViewed as $i => $product) {
            $name = e($product->name ?: 'Product #' . $product->id);
            $imageUrl = $product->featuredImage?->url ?? null;
            $label = $imageUrl
                ? new HtmlString('<span style="display:inline-flex;align-items:center;gap:0.5rem;"><img src="' . e($imageUrl) . '" alt="" style="width:32px;height:32px;border-radius:50%;object-fit:cover;flex-shrink:0;" loading="lazy"><span style="min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' . $name . '</span></span>')
                : $name;

            $topThreeStats[] = Stat::make($label, number_format($product->view_count))
                ->color('gray')
                ->description($rankDescriptions[$i] ?? '');
        }

        $stats = [];
        $stats[] = Section::make('All stats')
            ->schema($allStats)
            ->columns(3)
            ->columnSpanFull();


        $stats[] = Section::make('Top three viewed')
            ->schema($topThreeStats)
            ->columns(3)
            ->columnSpanFull();

        return $stats;
    }
}
