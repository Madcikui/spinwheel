<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class GenerateQr extends Page
{
    protected string $view = 'filament.pages.generate-qr';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQrCode;

    protected static ?string $navigationLabel = 'QR Code';

    protected static ?string $title = 'QR Code Cabutan';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public function getSpinUrl(): string
    {
        return url('/spin');
    }

    public function getQrCode(): string
    {
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)
            ->generate($this->getSpinUrl())
            ->toHtml();
    }
}
