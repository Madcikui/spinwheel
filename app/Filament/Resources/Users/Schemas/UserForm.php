<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Nama'),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->required(fn ($context) => $context === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->label('Password'),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin — Akses penuh',
                        'staff' => 'Staff — Serah hadiah sahaja',
                    ])
                    ->required()
                    ->default('staff')
                    ->label('Peranan'),
            ]);
    }
}
