<?php

namespace App\Filament\Resources\SpinLogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SpinLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'id')
                    ->required(),
                Select::make('prize_id')
                    ->relationship('prize', 'id')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                DateTimePicker::make('claimed_at'),
                TextInput::make('claimed_by')
                    ->numeric(),
                DateTimePicker::make('spun_at')
                    ->required(),
            ]);
    }
}
