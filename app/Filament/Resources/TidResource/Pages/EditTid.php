<?php

namespace App\Filament\Resources\TidResource\Pages;

use App\Filament\Resources\TidResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTid extends EditRecord
{
    protected static string $resource = TidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
