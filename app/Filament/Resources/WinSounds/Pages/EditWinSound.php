<?php

namespace App\Filament\Resources\WinSounds\Pages;

use App\Filament\Resources\WinSounds\WinSoundResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWinSound extends EditRecord
{
    protected static string $resource = WinSoundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
