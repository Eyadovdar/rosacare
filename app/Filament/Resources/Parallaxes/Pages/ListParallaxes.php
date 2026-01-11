<?php

namespace App\Filament\Resources\Parallaxes\Pages;

use App\Filament\Resources\Parallaxes\ParallaxResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParallaxes extends ListRecords
{
    protected static string $resource = ParallaxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
