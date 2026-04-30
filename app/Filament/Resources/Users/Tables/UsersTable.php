<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Peranan')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'admin' => 'danger',
                        'staff' => 'info',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'admin' => 'Admin',
                        'staff' => 'Staff',
                    }),
                TextColumn::make('created_at')
                    ->label('Didaftar')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
