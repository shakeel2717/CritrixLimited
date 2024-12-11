<?php

namespace App\Filament\Resources\NetworkCommissionResource\Pages;

use App\Filament\Resources\NetworkCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNetworkCommissions extends ListRecords
{
    protected static string $resource = NetworkCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
