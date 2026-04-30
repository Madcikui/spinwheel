<?php

namespace App\Filament\Resources\BonusCodes\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BonusCodesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'unused' => 'info',
                        'used' => 'success',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'unused' => 'Belum Guna',
                        'used' => 'Dah Guna',
                    }),
                TextColumn::make('used_by_name')
                    ->label('Diguna Oleh')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('spinLog.prize.nama_hadiah')
                    ->label('Hadiah')
                    ->placeholder('-'),
                TextColumn::make('used_at')
                    ->label('Masa Guna')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'unused' => 'Belum Guna',
                        'used' => 'Dah Guna',
                    ])
                    ->label('Status'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->label('Padam')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            $count = $records->count();
                            $records->each->delete();

                            \Filament\Notifications\Notification::make()
                                ->title("{$count} codes telah dipadam!")
                                ->success()
                                ->send();
                        }),

                    BulkAction::make('export')
                        ->label('Download Excel')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            $export = new class($records) implements FromCollection, WithHeadings {
                                public function __construct(protected Collection $records) {}
                                public function collection() {
                                    return $this->records->map(fn ($r) => [
                                        'Code' => $r->code,
                                        'Status' => $r->status === 'unused' ? 'Belum Guna' : 'Dah Guna',
                                        'Diguna Oleh' => $r->used_by_name ?? '-',
                                        'Hadiah' => $r->spinLog?->prize?->nama_hadiah ?? '-',
                                        'Masa Guna' => $r->used_at?->format('d/m/Y H:i') ?? '-',
                                        'Dibuat' => $r->created_at->format('d/m/Y H:i'),
                                    ]);
                                }
                                public function headings(): array {
                                    return ['Code', 'Status', 'Diguna Oleh', 'Hadiah', 'Masa Guna', 'Dibuat'];
                                }
                            };

                            return Excel::download($export, 'bonus-codes.xlsx');
                        }),
                ]),
            ]);
    }
}
