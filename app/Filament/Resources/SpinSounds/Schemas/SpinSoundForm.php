<?php

namespace App\Filament\Resources\SpinSounds\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SpinSoundForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama')
                    ->placeholder('Contoh: Drum Roll')
                    ->helperText('Label rujukan untuk muzik ini.'),
                FileUpload::make('file_path')
                    ->required()
                    ->label('File MP3')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                    ->disk('public')
                    ->directory('spin-sounds')
                    ->maxSize(10240)
                    ->helperText('Maks 10MB. Format: MP3. Lagu akan dimainkan masa wheel berputar.'),
                Toggle::make('aktif')
                    ->default(true)
                    ->label('Aktif')
                    ->helperText('Hanya muzik aktif akan dimainkan secara rawak masa spin.'),
            ]);
    }
}
