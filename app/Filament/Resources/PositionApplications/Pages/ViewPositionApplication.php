<?php

namespace App\Filament\Resources\PositionApplications\Pages;

use App\Filament\Resources\PositionApplications\PositionApplicationResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPositionApplication extends ViewRecord
{
    protected static string $resource = PositionApplicationResource::class;

    /**
     * Mark the application as read when viewing
     */
    public function mount(int | string $record): void
    {
        parent::mount($record);

        // Mark the application as read when viewed
        if ($this->record && !$this->record->is_read) {
            $this->record->markAsRead();
        }
    }
}

