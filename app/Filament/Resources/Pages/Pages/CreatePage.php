<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure header_image_path includes the directory prefix if not already present
        if (isset($data['header_image_path']) && !empty($data['header_image_path'])) {
            $path = $data['header_image_path'];
            
            // If path doesn't include the directory, prepend it
            if (!str_contains($path, 'pages/headers/')) {
                // Remove any leading slashes and prepend the directory
                $path = 'pages/headers/' . ltrim($path, '/');
                $data['header_image_path'] = $path;
            }
        }

        return $data;
    }
}
