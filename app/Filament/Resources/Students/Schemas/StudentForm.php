<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\Umur;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('branch_id')
                    ->relationship('branch', 'nama_cawangan')
                    ->required()
                    ->label('Cawangan'),
                TextInput::make('nama_pelajar')
                    ->required()
                    ->label('Nama Pelajar'),
                TextInput::make('ic_pelajar')
                    ->label('IC Pelajar')
                    ->maxLength(20),
                TextInput::make('kelas')
                    ->label('Kelas'),
                Select::make('umur_id')
                    ->label('Umur')
                    ->options(Umur::where('aktif', true)->pluck('nama', 'id'))
                    ->placeholder('Pilih Umur')
                    ->nullable(),
                TextInput::make('nama_ayah')
                    ->label('Nama Ayah')
                    ->maxLength(255),
                TextInput::make('ic_ayah')
                    ->label('IC Ayah')
                    ->maxLength(20),
                TextInput::make('nama_ibu')
                    ->label('Nama Ibu')
                    ->maxLength(255),
                TextInput::make('ic_ibu')
                    ->label('IC Ibu')
                    ->maxLength(20),
                TextInput::make('no_telefon')
                    ->tel()
                    ->label('No Telefon'),
            ]);
    }
}
