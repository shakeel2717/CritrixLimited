<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    public function getTabs(): array
    {
        return [
            'RealTransactions' => Tab::make('Real Transactions')->modifyQueryUsing(function ($query) {
                return $query->whereHas('user', function ($query) {
                    $query->where('fake', false);
                });
            }),

            'FakeTransactions' => Tab::make('Fake Transactions')->modifyQueryUsing(function ($query) {
                return $query->whereHas('user', function ($query) {
                    $query->where('fake', true);
                });
            }),

            'All' => Tab::make('All Transactions'),
        ];
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
