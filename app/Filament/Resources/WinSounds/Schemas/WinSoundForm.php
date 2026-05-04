<?php

namespace App\Filament\Resources\WinSounds\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class WinSoundForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama')
                    ->placeholder('Contoh: Kembang Api')
                    ->helperText('Label rujukan untuk muzik ini.'),
                FileUpload::make('file_path')
                    ->required()
                    ->label('File MP3')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                    ->disk('public')
                    ->directory('win-sounds')
                    ->preserveFilenames()
                    ->maxSize(10240)
                    ->helperText('Maks 10MB. Format: MP3.'),
                Toggle::make('aktif')
                    ->default(true)
                    ->label('Aktif')
                    ->helperText('Hanya muzik aktif akan dimainkan secara rawak selepas spin.'),
            ]);
    }
}
