<?php

namespace App\Filament\Resources\Umurs\Pages;

use App\Filament\Resources\Umurs\UmurResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUmurs extends ListRecords
{
    protected static string $resource = UmurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
