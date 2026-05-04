<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SpinSettings extends Page
{
    protected string $view = 'filament.pages.spin-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Tetapan';

    protected static ?string $title = 'Tetapan Spin';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $existingFile = Setting::get('bgm_file');

        $this->form->fill([
            'spin_password' => Setting::get('spin_password', 'TFE2026'),
            'event_name' => Setting::get('event_name', 'Hari Anugerah & Cabutan Bertuah'),
            'instruction_text' => Setting::get('instruction_text', 'Sila ke kaunter hadiah untuk menuntut hadiah anda'),
            'bgm_type' => Setting::get('bgm_type', 'stock'),
            'bgm_file' => $existingFile ? [$existingFile] : [],
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Umum')
                    ->schema([
                        TextInput::make('spin_password')
                            ->label('Password Spin Page')
                            ->required()
                            ->helperText('Password yang parent perlu masukkan sebelum akses spin page.'),
                        TextInput::make('event_name')
                            ->label('Nama Event')
                            ->required()
                            ->helperText('Contoh: Hari Anugerah & Cabutan Bertuah'),
                        TextInput::make('instruction_text')
                            ->label('Mesej Arahan Hadiah')
                            ->required()
                            ->helperText('Contoh: Sila ke kaunter hadiah untuk menuntut hadiah anda'),
                    ]),
                Section::make('Background Music')
                    ->schema([
                        Select::make('bgm_type')
                            ->label('Jenis Muzik')
                            ->options([
                                'off' => 'Tiada Muzik',
                                'stock' => 'Muzik Stock (Bass + Drums + Arpeggio)',
                                'mp3' => 'Upload MP3',
                            ])
                            ->default('stock')
                            ->required()
                            ->live()
                            ->helperText('Pilih jenis background music untuk spin page.'),
                        FileUpload::make('bgm_file')
                            ->label('File MP3')
                            ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                            ->disk('public')
                            ->directory('bgm')
                            ->preserveFilenames()
                            ->maxSize(10240)
                            ->visible(fn ($get) => $get('bgm_type') === 'mp3')
                            ->helperText('Maks 10MB. Format: MP3.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('spin_password', $data['spin_password']);
        Setting::set('event_name', $data['event_name']);
        Setting::set('instruction_text', $data['instruction_text']);
        Setting::set('bgm_type', $data['bgm_type']);

        if ($data['bgm_type'] === 'mp3' && ! empty($data['bgm_file'])) {
            $filePath = is_array($data['bgm_file']) ? (string) end($data['bgm_file']) : (string) $data['bgm_file'];
            $oldFile = Setting::get('bgm_file');

            if ($filePath !== '' && $filePath !== $oldFile) {
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
                Setting::set('bgm_file', $filePath);
            }
        }

        Notification::make()
            ->title('Tetapan berjaya disimpan!')
            ->success()
            ->send();
    }
}
