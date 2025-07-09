<?php

namespace App\Filament\Resources\EmployeeGroupResource\Pages;

use App\Filament\Resources\EmployeeGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmployeeGroups extends ManageRecords
{
    protected static string $resource = EmployeeGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
