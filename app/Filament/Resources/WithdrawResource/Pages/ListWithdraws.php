<?php

namespace App\Filament\Resources\WithdrawResource\Pages;

use App\Filament\Resources\WithdrawResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListWithdraws extends ListRecords
{
    protected static string $resource = WithdrawResource::class;

    public function getTabs(): array
    {
        return [
            'Approved Withdrawals' => Tab::make('Approved Withdrawals')->modifyQueryUsing(function ($query) {
                return $query->where('status', true);
            }),
            'Pending Withdrawals' => Tab::make('Pending Withdrawals')->modifyQueryUsing(function ($query) {
                return $query->where('status', false);
            }),
            'All' => Tab::make('All Withdrawals'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
