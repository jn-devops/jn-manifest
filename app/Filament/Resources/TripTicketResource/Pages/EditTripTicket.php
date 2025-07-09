<?php

namespace App\Filament\Resources\TripTicketResource\Pages;

use App\Filament\Resources\TripTicketResource;
use App\Notifications\ApprovedNotification;
use App\Notifications\ForApprovalNotification;
use App\Notifications\ForRevisionNotification;
use App\Notifications\RejectedNotification;
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
                    $record->setStatus($data['status'], $data['remarks']??'');
                    $latestStatus = $record->status();
                    $latestStatus->user_id = auth()->user()->id;
                    $latestStatus->save();
                    $record->status=$data['status'];
                    $record->save();

                    match ($data['status']) {
                        'For Approval' => $record->employee->notify(new ForApprovalNotification),
                        'Rejected' => $record->employee->notify(new RejectedNotification),
                        'For Revision' => $record->employee->notify(new ForRevisionNotification),
                        'Approved' => $record->employee->notify(new ApprovedNotification),
                    };
                })->modalWidth(MaxWidth::ScreenSmall),
        ];
    }
//    protected function mutateFormDataBeforeFill(array $data): array
//    {
//        $data['ticket_number'] = $this->record->ticket_number;
//        $data['request_for_payment_number'] = $this->record->request_for_payment_number;
//        $data['invoice_number'] = $this->record->invoice_number;
//        $data['drop_off_point'] = $this->record->drop_off_point;
//        $data['pickup_point'] = $this->record->pick_up_point;
//        $data['charge_to'] = $this->record->charge_to;
//        $data['provider_code'] = $this->record->provider_code;
//        $data['attachments'] = $this->record->attachments;
//
//        return $data;
//    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        return $record;
    }
    protected function afterSave(): void
    {
//        dd($this->record);
    }
}
