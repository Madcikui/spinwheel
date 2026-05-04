<?php

namespace App\Filament\Resources\SpinSounds\Pages;

use App\Filament\Resources\SpinSounds\SpinSoundResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpinSounds extends ListRecords
{
    protected static string $resource = SpinSoundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
