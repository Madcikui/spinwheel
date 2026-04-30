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

    public ?string $spin_password = '';
    public ?string $event_name = '';
    public ?string $instruction_text = '';
    public ?string $bgm_type = 'stock';
    public ?array $bgm_file = null;

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->spin_password = Setting::get('spin_password', 'TFE2026');
        $this->event_name = Setting::get('event_name', 'Hari Anugerah & Cabutan Bertuah');
        $this->instruction_text = Setting::get('instruction_text', 'Sila ke kaunter hadiah untuk menuntut hadiah anda');
        $this->bgm_type = Setting::get('bgm_type', 'stock');

        $existingFile = Setting::get('bgm_file');
        $this->bgm_file = $existingFile ? [$existingFile] : null;
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
                            ->directory('bgm')
                            ->maxSize(10240)
                            ->visible(fn ($get) => $get('bgm_type') === 'mp3')
                            ->helperText('Maks 10MB. Format: MP3.'),
                    ]),
            ]);
    }

    public function save(): void
    {
        Setting::set('spin_password', $this->spin_password);
        Setting::set('event_name', $this->event_name);
        Setting::set('instruction_text', $this->instruction_text);
        Setting::set('bgm_type', $this->bgm_type);

        // Handle BGM file
        if ($this->bgm_type === 'mp3' && !empty($this->bgm_file)) {
            $filePath = is_array($this->bgm_file) ? (end($this->bgm_file) ?: '') : $this->bgm_file;
            $oldFile = Setting::get('bgm_file');

            if ($filePath && $filePath !== $oldFile) {
                // Delete old file if different
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
