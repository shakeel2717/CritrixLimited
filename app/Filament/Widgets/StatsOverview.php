<?php

namespace App\Filament\Widgets;

use App\Models\Kyc;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::where('fake', false)->count()),
            Stat::make('Active Users', User::where('fake', false)->where('status', 'active')->count()),
            Stat::make('In-Active Users', User::where('fake', false)->where('status', 'inactive')->count()),
        ];
    }
}
