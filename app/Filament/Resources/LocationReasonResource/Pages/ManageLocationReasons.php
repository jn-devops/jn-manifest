<?php

namespace App\Filament\Resources\LocationReasonResource\Pages;

use App\Filament\Resources\LocationReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLocationReasons extends ManageRecords
{
    protected static string $resource = LocationReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
