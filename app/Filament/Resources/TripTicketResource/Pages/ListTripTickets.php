<?php

namespace App\Filament\Resources\TripTicketResource\Pages;

use App\Filament\Resources\TripTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTripTickets extends ListRecords
{
    protected static string $resource = TripTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
