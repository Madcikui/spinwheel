<?php

namespace App\Filament\Resources\BonusCodes\Pages;

use App\Filament\Resources\BonusCodes\BonusCodeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBonusCode extends EditRecord
{
    protected static string $resource = BonusCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
