<?php

namespace App\Filament\Resources\SpinLogs\Pages;

use App\Filament\Resources\SpinLogs\SpinLogResource;
use App\Models\SpinLog;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class ListSpinLogs extends ListRecords
{
    protected static string $resource = SpinLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Download Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $export = new class implements FromCollection, WithHeadings {
                        public function collection()
                        {
                            return SpinLog::with(['student.branch', 'prize'])->orderByDesc('spun_at')->get()->map(function ($r) {
                                $nama = $r->student?->nama_pelajar;
                                if (!$nama) {
                                    $bonus = \App\Models\BonusCode::where('spin_log_id', $r->id)->first();
                                    $nama = $bonus ? $bonus->used_by_name . ' (Bonus)' : '-';
                                }

                                return [
                                    'Nama' => $nama,
                                    'IC Ayah' => $r->student?->ic_ayah ?? '-',
                                    'Cawangan' => $r->student?->branch?->nama_cawangan ?? '-',
                                    'Hadiah' => $r->prize->nama_hadiah,
                                    'Status' => $r->status === 'pending' ? 'Belum Serah' : 'Dah Serah',
                                    'Masa Spin' => $r->spun_at->format('d/m/Y H:i'),
                                    'Masa Serah' => $r->claimed_at?->format('d/m/Y H:i') ?? '-',
                                ];
                            });
                        }

                        public function headings(): array
                        {
                            return ['Nama', 'IC Ayah', 'Cawangan', 'Hadiah', 'Status', 'Masa Spin', 'Masa Serah'];
                        }
                    };

                    return Excel::download($export, 'senarai-pemenang.xlsx');
                }),
        ];
    }
}
