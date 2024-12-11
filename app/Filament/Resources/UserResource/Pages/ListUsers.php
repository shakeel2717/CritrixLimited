<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        return [
            'Only Users' => Tab::make('Only Users')->modifyQueryUsing(function ($query) {
                return $query->where('fake', false)->where('role', '!=', 'admin');
            }),
            'Only Admins' => Tab::make('Admin Account')->modifyQueryUsing(function ($query) {
                return $query->where('fake', false)->where('role', '!=', 'user');
            }),
            'Fake users' => Tab::make('Fake Users')->modifyQueryUsing(function ($query) {
                return $query->where('fake', true);
            }),
            'All' => Tab::make('All users'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
