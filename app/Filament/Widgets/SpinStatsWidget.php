<?php

namespace App\Filament\Widgets;

use App\Models\Prize;
use App\Models\SpinLog;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SpinStatsWidget extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $totalStudents = Student::count();
        $totalSpun = SpinLog::count();
        $pendingClaim = SpinLog::where('status', 'pending')->count();
        $claimed = SpinLog::where('status', 'claimed')->count();
        $totalPrizesLeft = Prize::where('aktif', true)->sum('kuantiti_baki');

        return [
            Stat::make('Jumlah Pelajar', $totalStudents)
                ->description($totalSpun . ' sudah spin')
                ->color('primary'),
            Stat::make('Belum Serah', $pendingClaim)
                ->description('Menunggu di kaunter')
                ->color($pendingClaim > 0 ? 'warning' : 'success'),
            Stat::make('Dah Serah', $claimed)
                ->description('Hadiah telah diserahkan')
                ->color('success'),
            Stat::make('Baki Hadiah', $totalPrizesLeft)
                ->description('Jumlah hadiah yang tinggal')
                ->color($totalPrizesLeft <= 5 ? 'danger' : 'primary'),
        ];
    }
}
