<?php

namespace App\Filament\Resources\FacultiesResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Faculties;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\ComponentContainer;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public function form(Form $form): Form
    {
        $option_data = Faculties::pluck('faculty_name', 'id')->toArray();

        return $form
            ->schema([
                TextInput::make('nim')->required()->unique(ignorable: fn ($record) => $record),
                TextInput::make('nama')->required(),
                Select::make('jk')
                ->options([
                    'Laki' => 'Laki', 
                    'Perempuan' => 'Perempuan',
                ])->label('Jenis Kelamin')->required(),
                Select::make('id_fakultas')->options($option_data)->label('Nama Fakultas')->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('nim')->label('NIM')->sortable()->searchable(),
                TextColumn::make('nama')->sortable()->searchable(),
                TextColumn::make('jk')->label('Jenis Kelamin')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function saveRecord($record, ComponentContainer $components): void
    {
        parent::saveRecord($record, $components);

        if ($record->wasRecentlyCreated) {
            Notification::make()
                ->success()
                ->title('Student ' . $record->nama)
                ->body('The student has been created successfully.')
                ->sendToDatabase(auth()->user());
        }
    }
}
