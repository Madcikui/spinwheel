<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use App\Imports\StudentsImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('template')
                ->label('Download Template')
                ->icon('heroicon-o-document-arrow-down')
                ->color('gray')
                ->action(function () {
                    $export = new class implements FromArray, WithHeadings {
                        public function array(): array {
                            return [
                                ['Ahmad Aqil bin Hafizi', '', 'Mohd Hafizi bin Ahmad', '901231041234', 'Siti Aminah binti Omar', '920515081234', '0123456789', '5 Bestari'],
                                ['Nur Insyirah binti Faizal', '', 'Mohd Faizal bin Hassan', '880420105678', 'Nor Aini binti Yusuf', '900310069876', '0198765432', '4 Cemerlang'],
                            ];
                        }
                        public function headings(): array {
                            return ['nama_pelajar', 'ic_pelajar', 'nama_ayah', 'ic_ayah', 'nama_ibu', 'ic_ibu', 'no_telefon', 'kelas'];
                        }
                    };

                    return Excel::download($export, 'template-pelajar.xlsx');
                }),

            Action::make('import')
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    Select::make('branch_id')
                        ->relationship('branch', 'nama_cawangan')
                        ->required()
                        ->label('Cawangan'),
                    FileUpload::make('file')
                        ->label('Fail Excel')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $filePath = storage_path('app/public/' . $data['file']);

                    // Fallback: check if file exists at other common paths
                    if (!file_exists($filePath)) {
                        $filePath = storage_path('app/livewire-tmp/' . $data['file']);
                    }
                    if (!file_exists($filePath)) {
                        $filePath = storage_path('app/' . $data['file']);
                    }

                    if (!file_exists($filePath)) {
                        Notification::make()
                            ->title('Fail tidak dijumpai. Sila cuba lagi.')
                            ->danger()
                            ->send();
                        return;
                    }

                    try {
                        Excel::import(new StudentsImport($data['branch_id']), $filePath);

                        Notification::make()
                            ->title('Berjaya import pelajar!')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Gagal import!')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            CreateAction::make(),
        ];
    }
}
