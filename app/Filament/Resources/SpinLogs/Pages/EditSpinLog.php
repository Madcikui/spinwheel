<?php

namespace App\Filament\Resources\SpinLogs\Pages;

use App\Filament\Resources\SpinLogs\SpinLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpinLog extends EditRecord
{
    protected static string $resource = SpinLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
