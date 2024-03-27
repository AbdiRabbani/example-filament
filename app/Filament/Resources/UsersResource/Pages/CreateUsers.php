<?php

namespace App\Filament\Resources\UsersResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use App\Filament\Resources\UsersResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        $record = $this->record;
        return Notification::make()
            ->success()
            ->title('User ' . $record->name)
            ->body('The User has been created successfully.')
            ->sendToDatabase(auth()->user());
    }
}
