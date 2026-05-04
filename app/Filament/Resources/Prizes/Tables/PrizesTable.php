<?php

namespace App\Filament\Resources\Prizes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrizesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public')
                    ->size(40)
                    ->circular(),
                TextColumn::make('nama_hadiah')
                    ->label('Hadiah')
                    ->searchable(),
                TextColumn::make('umur.nama')
                    ->label('Umur')
                    ->default('Semua')
                    ->badge()
                    ->color(fn ($state) => $state === 'Semua' ? 'gray' : 'info'),
                TextColumn::make('kuantiti')
                    ->label('Jumlah Asal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kuantiti_baki')
                    ->label('Baki')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($state) => $state <= 0 ? 'danger' : ($state <= 3 ? 'warning' : 'success')),
                ColorColumn::make('warna')
                    ->label('Warna'),
                IconColumn::make('aktif')
                    ->boolean()
                    ->label('Aktif'),
                IconColumn::make('boleh_bonus')
                    ->boolean()
                    ->label('Bonus Code')
                    ->tooltip(fn ($state) => $state ? 'Hadiah ini termasuk dalam bonus code' : 'Hadiah ini DIKECUALIKAN dari bonus code'),
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
