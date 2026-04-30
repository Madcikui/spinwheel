<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch.nama_cawangan')
                    ->label('Cawangan')
                    ->sortable(),
                TextColumn::make('nama_pelajar')
                    ->label('Nama Pelajar')
                    ->searchable(),
                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->sortable(),
                TextColumn::make('umur.nama')
                    ->label('Umur')
                    ->sortable(),
                TextColumn::make('nama_ayah')
                    ->label('Nama Ayah')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('ic_ayah')
                    ->label('IC Ayah')
                    ->searchable(),
                TextColumn::make('nama_ibu')
                    ->label('Nama Ibu')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('ic_ibu')
                    ->label('IC Ibu')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('no_telefon')
                    ->label('No Telefon')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('spinLog.id')
                    ->label('Sudah Spin')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->spinLog !== null),
            ])
            ->filters([
                SelectFilter::make('branch_id')
                    ->relationship('branch', 'nama_cawangan')
                    ->label('Cawangan'),
                SelectFilter::make('umur_id')
                    ->relationship('umur', 'nama')
                    ->label('Umur'),
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
