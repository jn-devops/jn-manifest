<?php

namespace App\Filament\Resources\TripTicketResource\Pages;

use App\Filament\Resources\TripTicketResource;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;
use Howdu\FilamentRecordSwitcher\Filament\Concerns\HasRecordSwitcher;
use Illuminate\Database\Eloquent\Model;

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
                ->form(Function (Form $form, Model $record) {
                    return $form->schema([
                        Select::make('status')
                            ->native(false)
                            ->required()
                            ->options([
                                'For Approval'=>'For Approval',
                                'Rejected'=>'Rejected',
                                'For Revision'=>'For Revision',
                                'Approved'=>'Approved',
                            ])
                            ->default($record->status)
                            ->live(),
                        Textarea::make('remarks')
                            ->required(fn(Get $get)=>!$get('status')=='For Revision'||$get('status')==='Rejected')
                            ->rows(5)
                            ->columns(5)
                            ->maxLength(255),
                    ]);
                })
                ->action(function (Model $record, array $data) {
                    $record->setStatus($data['status'], $data['remarks']);
                    $record->status=$data['status'];
                    $record->save();
                })->modalWidth(MaxWidth::ScreenSmall),
        ];
    }
}
