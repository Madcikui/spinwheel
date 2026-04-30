<?php

namespace App\Filament\Resources\Prizes\Schemas;

use App\Models\Umur;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PrizeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_hadiah')
                    ->required()
                    ->label('Nama Hadiah'),
                Select::make('umur_id')
                    ->label('Umur Pelajar')
                    ->options(Umur::where('aktif', true)->pluck('nama', 'id'))
                    ->placeholder('Semua Umur')
                    ->nullable(),
                FileUpload::make('gambar')
                    ->label('Gambar Hadiah')
                    ->image()
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                    ->directory('prizes')
                    ->imagePreviewHeight('150')
                    ->maxSize(2048),
                TextInput::make('kuantiti')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->label('Kuantiti Asal')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('kuantiti_baki', $state)),
                TextInput::make('kuantiti_baki')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->label('Kuantiti Baki'),
                ColorPicker::make('warna')
                    ->required()
                    ->default('#FF6384')
                    ->label('Warna Wheel'),
                Toggle::make('aktif')
                    ->default(true)
                    ->label('Aktif'),
            ]);
    }
}
