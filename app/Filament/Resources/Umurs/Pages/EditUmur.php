<?php

namespace App\Filament\Resources\Umurs\Pages;

use App\Filament\Resources\Umurs\UmurResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUmur extends EditRecord
{
    protected static string $resource = UmurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
