<?php

namespace App\Filament\Resources\BonusCodes\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BonusCodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('unused'),
                TextInput::make('used_by_name'),
                Select::make('spin_log_id')
                    ->relationship('spinLog', 'id'),
                DateTimePicker::make('used_at'),
            ]);
    }
}
