<?php

namespace App\Filament\Resources\FacultiesResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\FacultiesResource;

class CreateFaculties extends CreateRecord
{
    protected static string $resource = FacultiesResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        $record = $this->record;
        return Notification::make()
            ->success()
            ->title('Faculty ' . $record->faculty_name)
            ->body('The faculty has been created successfully.')
            ->sendToDatabase(auth()->user());
    }
}
