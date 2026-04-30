<?php

namespace App\Filament\Resources\Umurs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UmurForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Umur')
                    ->placeholder('Contoh: 4 Tahun'),
                Toggle::make('aktif')
                    ->default(true)
                    ->label('Aktif'),
            ]);
    }
}
