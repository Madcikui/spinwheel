<?php

namespace App\Filament\Resources\WinSounds;

use App\Filament\Resources\WinSounds\Pages\CreateWinSound;
use App\Filament\Resources\WinSounds\Pages\EditWinSound;
use App\Filament\Resources\WinSounds\Pages\ListWinSounds;
use App\Filament\Resources\WinSounds\Schemas\WinSoundForm;
use App\Filament\Resources\WinSounds\Tables\WinSoundsTable;
use App\Models\WinSound;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WinSoundResource extends Resource
{
    protected static ?string $model = WinSound::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMusicalNote;

    protected static ?string $navigationLabel = 'Muzik Menang';

    protected static ?string $modelLabel = 'Muzik Menang';

    protected static ?string $pluralModelLabel = 'Muzik Menang';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return WinSoundForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WinSoundsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWinSounds::route('/'),
            'create' => CreateWinSound::route('/create'),
            'edit' => EditWinSound::route('/{record}/edit'),
        ];
    }
}
