<?php

namespace App\Filament\Resources\SpinLogs\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class SpinLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('spun_at', 'desc')
            ->columns([
                TextColumn::make('student.nama_pelajar')
                    ->label('Nama')
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        if ($record->student) return $record->student->nama_pelajar;
                        $bonus = \App\Models\BonusCode::where('spin_log_id', $record->id)->first();
                        return $bonus ? $bonus->used_by_name . ' (Bonus)' : '-';
                    }),
                TextColumn::make('prize.nama_hadiah')
                    ->label('Hadiah'),
                TextColumn::make('student.branch.nama_cawangan')
                    ->label('Cawangan')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'claimed' => 'success',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending' => 'Belum Serah',
                        'claimed' => 'Dah Serah',
                    }),
                TextColumn::make('spun_at')
                    ->label('Masa Spin')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('claimed_at')
                    ->label('Masa Serah')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('student.ic_ayah')
                    ->label('IC Ayah')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Belum Serah',
                        'claimed' => 'Dah Serah',
                    ])
                    ->label('Status'),
                SelectFilter::make('branch')
                    ->relationship('student.branch', 'nama_cawangan')
                    ->label('Cawangan'),
            ])
            ->recordActions([
                Action::make('serah')
                    ->label('Serah Hadiah')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Sahkan Serah Hadiah')
                    ->modalDescription(function ($record) {
                        $nama = $record->student?->nama_pelajar
                            ?? \App\Models\BonusCode::where('spin_log_id', $record->id)->value('used_by_name')
                            ?? 'Pemenang';
                        return "Serah hadiah \"{$record->prize->nama_hadiah}\" kepada {$nama}?";
                    })
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'claimed',
                            'claimed_at' => now(),
                            'claimed_by' => Auth::id(),
                        ]);

                        Notification::make()
                            ->title('Hadiah telah diserahkan!')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'pending'),

                Action::make('revoke')
                    ->label('Revoke Spin')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Revoke Cabutan')
                    ->modalDescription(function ($record) {
                        $nama = $record->student?->nama_pelajar
                            ?? \App\Models\BonusCode::where('spin_log_id', $record->id)->value('used_by_name')
                            ?? 'Pemenang';
                        return "Revoke cabutan {$nama}? Hadiah \"{$record->prize->nama_hadiah}\" akan dikembalikan ke stok.";
                    })
                    ->action(function ($record) {
                        // Return prize stock
                        $record->prize->increment('kuantiti_baki');

                        // Delete spin log
                        $record->delete();

                        Notification::make()
                            ->title('Cabutan telah di-revoke!')
                            ->body('Hadiah dikembalikan ke stok. Pelajar boleh spin semula.')
                            ->warning()
                            ->send();
                    })
                    ->visible(fn ($record) => Auth::user()->role === 'admin'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('serah_semua')
                        ->label('Serah Semua')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each(fn ($record) => $record->update([
                                'status' => 'claimed',
                                'claimed_at' => now(),
                                'claimed_by' => Auth::id(),
                            ]));

                            Notification::make()
                                ->title($records->count() . ' hadiah telah diserahkan!')
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }
}
