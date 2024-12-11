<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class TransactionOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Deposit', Number::currency(Transaction::whereHas('user', function ($query) {
                $query->where('fake', false);
            })->where('type', 'deposit')->sum('amount'))),
            Stat::make('Total Withdraw', Number::currency(Transaction::whereHas('user', function ($query) {
                $query->where('fake', false);
            })->where('type', 'withdraw')->sum('amount'))),
            Stat::make('Total KYC Bonus', Number::currency(Transaction::whereHas('user', function ($query) {
                $query->where('fake', false);
            })->where('type', 'kyc bonus')->sum('amount'))),
        ];
    }
}
