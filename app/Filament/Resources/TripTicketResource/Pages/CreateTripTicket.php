<?php

namespace App\Filament\Resources\TripTicketResource\Pages;

use App\Filament\Resources\TripTicketResource;
use App\Models\Account;
use App\Models\CarType;
use App\Models\Employee;
use App\Models\Manifest;
use App\Models\Project;
use App\Models\TripTicket;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use PHPUnit\Framework\Attributes\Ticket;
use App\Actions\CreateTripTicket as AppCreateTripTicket;

class CreateTripTicket extends CreateRecord
{
    protected static string $resource = TripTicketResource::class;


    protected function handleRecordCreation(array $data): TripTicket
    {
        // Run the CreateTripTicket service to create the TripTicket instance
        $tripTicket = app(AppCreateTripTicket::class)->run(
            auth()->user(),                        // Pass the authenticated user instance
            Employee::find($data['employee_id']),  // Find the related employee
            CarType::find($data['car_type_id']),   // Find the related car type
            Project::find($data['project_id']),    // Find the related project
            Account::find($data['account_id']),    // Find the related account
            new Carbon($data['fromDateTime']),     // Parse fromDateTime to Carbon
            new Carbon($data['toDateTime']),       // Parse toDateTime to Carbon
            $data['remarks'],
            $data['location']
        );

        $tripTicket->provider_code = $data['provider_code'];
        $tripTicket->drop_off_point = $data['drop_off_point'];
        $tripTicket->pick_up_point = $data['pick_up_point'];
        $tripTicket->invoice_number = $data['invoice_number'];
        $tripTicket->request_for_payment_number = $data['request_for_payment_number'];
        $tripTicket->attachments= $data['attachments'];

        // After creating the TripTicket, add manifests if necessary
        foreach ($data['manifests'] as $manifestData) {
            $manifest = new Manifest();
            $manifest->name = $manifestData['name'];
            $manifest->passenger_type = $manifestData['passenger_type'];
            $tripTicket->manifests()->save($manifest);  // Save each manifest to the TripTicket
        }
        $tripTicket->save();
        Notification::make()
            ->title('Saved successfully')
            ->sendToDatabase(auth()->user(), isEventDispatched: true);
        return $tripTicket;
    }


}
