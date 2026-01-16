<?php

namespace App\Filament\Resources\Contacts\Pages;

use App\Filament\Resources\Contacts\ContactResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //EditAction::make(),
        ];
    }

    /**
     * Mark the contact as read when viewing
     */
    public function mount(int | string $record): void
    {
        parent::mount($record);

        // Mark the contact as read when viewed
        if ($this->record && !$this->record->is_read) {
            $this->record->markAsRead();
        }
    }
}
