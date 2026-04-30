<?php

namespace App\Filament\Resources\BonusCodes;

use App\Filament\Resources\BonusCodes\Pages\ListBonusCodes;
use App\Filament\Resources\BonusCodes\Schemas\BonusCodeForm;
use App\Filament\Resources\BonusCodes\Tables\BonusCodesTable;
use App\Models\BonusCode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class BonusCodeResource extends Resource
{
    protected static ?string $model = BonusCode::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?string $navigationLabel = 'Bonus Code';

    protected static ?string $modelLabel = 'Bonus Code';

    protected static ?string $pluralModelLabel = 'Bonus Codes';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return BonusCodeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BonusCodesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBonusCodes::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
