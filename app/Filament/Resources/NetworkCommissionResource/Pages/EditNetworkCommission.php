<?php

namespace App\Filament\Resources\NetworkCommissionResource\Pages;

use App\Filament\Resources\NetworkCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNetworkCommission extends EditRecord
{
    protected static string $resource = NetworkCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
