<?php

namespace App\Filament\Resources\TripTicketResource\Pages;

use App\Filament\Resources\TripTicketResource;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditTripTicket extends EditRecord
{
    protected static string $resource = TripTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('update_status')
                ->label('Update Status')
                ->icon('heroicon-m-pencil-square')
                ->color('primary')
                ->form(Function (Form $form) {
                    return $form->schema([
                        Select::make('Status')
                            ->native(false)
                            ->required()
                            ->options([
                                'For Approval'=>'For Approval',
                                'Rejected'=>'Rejected',
                                'For Revision'=>'For Revision',
                                'Approved'=>'Approved',
                            ])
                    ]);
                }),
        ];
    }
}
