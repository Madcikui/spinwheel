<?php

namespace App\Filament\Resources\Umurs;

use App\Filament\Resources\Umurs\Pages\CreateUmur;
use App\Filament\Resources\Umurs\Pages\EditUmur;
use App\Filament\Resources\Umurs\Pages\ListUmurs;
use App\Filament\Resources\Umurs\Schemas\UmurForm;
use App\Filament\Resources\Umurs\Tables\UmursTable;
use App\Models\Umur;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UmurResource extends Resource
{
    protected static ?string $model = Umur::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Umur';

    protected static ?string $modelLabel = 'Umur';

    protected static ?string $pluralModelLabel = 'Umur';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return UmurForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UmursTable::configure($table);
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
            'index' => ListUmurs::route('/'),
            'create' => CreateUmur::route('/create'),
            'edit' => EditUmur::route('/{record}/edit'),
        ];
    }
}
