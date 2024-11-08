<?php

namespace App\Actions;

use App\Models\{Account, CarType,Employee, Project, TripTicket, User};
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateTripTicket
{
    use AsAction;

    /**
     * Creates a new trip ticket.
     *
     * @param User $user The authenticated user that submitted the request
     * @param Employee $employee The employee associated with the trip ticket
     * @param CarType $carType The car type associated with the trip ticket
     * @param Project $project The project associated with the trip ticket
     * @param Account $account The account associated with the trip ticket
     * @param Collection $manifests The manifests associated with the trip ticket
     * @param Carbon $fromDataTime The from date and time of the trip ticket
     * @param Carbon $toDataTime The to date and time of the trip ticket
     * @param string $remarks The remarks associated with the trip ticket
     * @param string $location The location associated with the trip ticket
     * @return TripTicket The newly created trip ticket
     */
    public function handle(User $user, Employee $employee, CarType $carType, Project $project, Account $account, Collection $manifests, Carbon $fromDataTime, Carbon $toDataTime, string $remarks, string $location): TripTicket
    {
        $tripTicket = new TripTicket;
        $tripTicket->user()->associate($user);
        $tripTicket->employee()->associate($employee);
        $tripTicket->carType()->associate($carType);
        $tripTicket->project()->associate($project);
        $tripTicket->account()->associate($account);
        $tripTicket->fromDateTime = $fromDataTime;
        $tripTicket->toDateTime = $toDataTime;
        $tripTicket->remarks = $remarks;
        $tripTicket->location = $location;
        $tripTicket->save();
        $tripTicket->setStatus('For Approval','New Request');
        $tripTicket->status = 'For Approval';
        $tripTicket->save();

        return $tripTicket;
    }
}
