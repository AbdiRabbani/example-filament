<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Students;
use Filament\Forms\Form;
use App\Models\Faculties;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\StudentsResource\Pages;

class StudentsResource extends Resource
{
    protected static ?string $model = Students::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $sort = 1;

    public static function form(Form $form): Form
    {
        $option_data = Faculties::pluck('faculty_name', 'id')->toArray();

        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nim')->required()->unique(ignorable: fn ($record) => $record),
                        TextInput::make('nama')->required(),
                        Select::make('jk')->options([
                            'Laki' => 'Laki', 
                            'Perempuan' => 'Perempuan'])->label('Jenis Kelamin')->required(),
                        Select::make('id_fakultas')->options($option_data)->label('Nama Fakultas')->required(),
                        FileUpload::make('photo')->directory('photo-students'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nim')->label('NIM')->sortable()->searchable(),
                TextColumn::make('nama')->sortable()->searchable(),
                ImageColumn::make('photo')
                ->defaultImageUrl(url('/images/placeholder-img.jpg'))
                ->stacked()
                ->limit(3)
                ->limitedRemainingText(isSeparate: true)
                ->circular(),           
                TextColumn::make('id_fakultas')
                ->label('Nama Fakultas')
                ->getStateUsing(function ($record) {
                    return $record->faculties->faculty_name ?? '';
                })
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudents::route('/create'),
            'edit' => Pages\EditStudents::route('/{record}/edit'),
        ];
    }
}
