<?php

namespace App\Filament\Resources\FacultiesResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\FacultiesResource;
use App\Filament\Resources\FacultiesResource\Widgets\StatsOverview;

class ListFaculties extends ListRecords
{
    protected static string $resource = FacultiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
