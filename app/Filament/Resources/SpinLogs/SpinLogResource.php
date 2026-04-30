<?php

namespace App\Filament\Resources\SpinLogs;

use App\Filament\Resources\SpinLogs\Pages\ListSpinLogs;
use App\Filament\Resources\SpinLogs\Schemas\SpinLogForm;
use App\Filament\Resources\SpinLogs\Tables\SpinLogsTable;
use App\Models\SpinLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SpinLogResource extends Resource
{
    protected static ?string $model = SpinLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;

    protected static ?string $navigationLabel = 'Senarai Pemenang';

    protected static ?string $modelLabel = 'Pemenang';

    protected static ?string $pluralModelLabel = 'Senarai Pemenang';

    public static function form(Schema $schema): Schema
    {
        return SpinLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpinLogsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSpinLogs::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
