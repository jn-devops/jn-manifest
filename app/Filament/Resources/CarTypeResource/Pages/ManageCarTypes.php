<?php

namespace App\Filament\Resources\CarTypeResource\Pages;

use App\Filament\Resources\CarTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCarTypes extends ManageRecords
{
    protected static string $resource = CarTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
