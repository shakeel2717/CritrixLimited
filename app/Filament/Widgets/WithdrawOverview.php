<?php

namespace App\Filament\Widgets;

use App\Models\Withdraw;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WithdrawOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Withdraw Request', Withdraw::whereHas('user', function ($query) {
                $query->where('fake', false);
            })->count()),
            Stat::make('Pending Withdraw Request', Withdraw::whereHas('user', function ($query) {
                $query->where('fake', false);
            })->where('status', false)->count()),
            Stat::make('Approved Withdraw Request', Withdraw::whereHas('user', function ($query) {
                $query->where('fake', false);
            })->where('status', true)->count()),
        ];
    }
}
