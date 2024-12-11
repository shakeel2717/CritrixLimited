<?php

namespace App\Filament\Resources\UserPlanResource\Pages;

use App\Filament\Resources\UserPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserPlans extends ListRecords
{
    protected static string $resource = UserPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
