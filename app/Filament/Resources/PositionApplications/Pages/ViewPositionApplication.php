<?php

namespace App\Filament\Resources\PositionApplications\Pages;

use App\Filament\Resources\PositionApplications\PositionApplicationResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPositionApplication extends ViewRecord
{
    protected static string $resource = PositionApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Print Report')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->action(function () {
                    return $this->js('window.print()');
                }),
            RestoreAction::make(),
            ForceDeleteAction::make(),
            DeleteAction::make(),
        ];
    }

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

