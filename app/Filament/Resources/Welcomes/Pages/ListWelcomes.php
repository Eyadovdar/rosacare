<?php

namespace App\Filament\Resources\Welcomes\Pages;

use App\Filament\Resources\Welcomes\WelcomeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWelcomes extends ListRecords
{
    protected static string $resource = WelcomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
