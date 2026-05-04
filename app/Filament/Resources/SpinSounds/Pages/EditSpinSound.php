<?php

namespace App\Filament\Resources\SpinSounds\Pages;

use App\Filament\Resources\SpinSounds\SpinSoundResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpinSound extends EditRecord
{
    protected static string $resource = SpinSoundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
