<?php

namespace App\Filament\Resources\SpinSounds;

use App\Filament\Resources\SpinSounds\Pages\CreateSpinSound;
use App\Filament\Resources\SpinSounds\Pages\EditSpinSound;
use App\Filament\Resources\SpinSounds\Pages\ListSpinSounds;
use App\Filament\Resources\SpinSounds\Schemas\SpinSoundForm;
use App\Filament\Resources\SpinSounds\Tables\SpinSoundsTable;
use App\Models\SpinSound;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SpinSoundResource extends Resource
{
    protected static ?string $model = SpinSound::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSpeakerWave;

    protected static ?string $navigationLabel = 'Muzik Spin';

    protected static ?string $modelLabel = 'Muzik Spin';

    protected static ?string $pluralModelLabel = 'Muzik Spin';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return SpinSoundForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpinSoundsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSpinSounds::route('/'),
            'create' => CreateSpinSound::route('/create'),
            'edit' => EditSpinSound::route('/{record}/edit'),
        ];
    }
}
