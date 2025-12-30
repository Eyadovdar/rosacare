<?php

namespace App\Filament\Resources\Welcomes\Pages;

use App\Filament\Resources\Welcomes\WelcomeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWelcome extends CreateRecord
{
    protected static string $resource = WelcomeResource::class;
}
