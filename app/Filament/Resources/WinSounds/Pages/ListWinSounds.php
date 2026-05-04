<?php

namespace App\Filament\Resources\WinSounds\Pages;

use App\Filament\Resources\WinSounds\WinSoundResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWinSounds extends ListRecords
{
    protected static string $resource = WinSoundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
