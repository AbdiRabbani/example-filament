<?php

namespace App\Filament\Resources\StudentsResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\StudentsResource;

class CreateStudents extends CreateRecord
{
    protected static string $resource = StudentsResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        $record = $this->record;
        return Notification::make()
            ->success()
            ->title('Student ' . $record->nama)
            ->body('The student has been created successfully.')
            ->sendToDatabase(auth()->user());
    }
}
