<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Faculties;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FacultiesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FacultiesResource\RelationManagers\StudentsRelationManager;

class FacultiesResource extends Resource
{
    protected static ?string $model = Faculties::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static $name = 'Fakultas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('faculty_name')->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('faculty_name'),
                ImageColumn::make('students.photo')
                ->defaultImageUrl(url('/images/placeholder-img.jpg'))
                ->stacked()
                ->limit(3)
                ->limitedRemainingText(isSeparate: true)
                ->circular(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaculties::route('/'),
            'create' => Pages\CreateFaculties::route('/create'),
            'edit' => Pages\EditFaculties::route('/{record}/edit'),
        ];
    }
}
