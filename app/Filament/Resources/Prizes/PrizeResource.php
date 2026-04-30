<?php

namespace App\Filament\Resources\Prizes;

use App\Filament\Resources\Prizes\Pages\CreatePrize;
use App\Filament\Resources\Prizes\Pages\EditPrize;
use App\Filament\Resources\Prizes\Pages\ListPrizes;
use App\Filament\Resources\Prizes\Schemas\PrizeForm;
use App\Filament\Resources\Prizes\Tables\PrizesTable;
use App\Models\Prize;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PrizeResource extends Resource
{
    protected static ?string $model = Prize::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;

    protected static ?string $navigationLabel = 'Hadiah';

    protected static ?string $modelLabel = 'Hadiah';

    protected static ?string $pluralModelLabel = 'Hadiah';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return PrizeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrizesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrizes::route('/'),
            'create' => CreatePrize::route('/create'),
            'edit' => EditPrize::route('/{record}/edit'),
        ];
    }
}
