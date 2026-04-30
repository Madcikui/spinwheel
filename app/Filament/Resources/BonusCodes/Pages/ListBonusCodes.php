<?php

namespace App\Filament\Resources\BonusCodes\Pages;

use App\Filament\Resources\BonusCodes\BonusCodeResource;
use App\Models\BonusCode;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class ListBonusCodes extends ListRecords
{
    protected static string $resource = BonusCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate Codes')
                ->icon('heroicon-o-sparkles')
                ->color('primary')
                ->form([
                    TextInput::make('quantity')
                        ->label('Berapa banyak code?')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->maxValue(100)
                        ->default(10),
                ])
                ->action(function (array $data) {
                    $count = (int) $data['quantity'];
                    BonusCode::generateBulk($count);

                    Notification::make()
                        ->title("Berjaya generate {$count} bonus codes!")
                        ->success()
                        ->send();
                }),

            Action::make('export_all')
                ->label('Download Semua')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $export = new class implements FromCollection, WithHeadings {
                        public function collection() {
                            return BonusCode::with('spinLog.prize')->get()->map(fn ($r) => [
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

                    return Excel::download($export, 'bonus-codes-semua.xlsx');
                }),
        ];
    }
}
