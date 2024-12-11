<?php

namespace App\Filament\Resources\UserPlanResource\Pages;

use App\Filament\Resources\UserPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserPlan extends EditRecord
{
    protected static string $resource = UserPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
