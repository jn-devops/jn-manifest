<?php

namespace App\Actions;

use App\Models\{Account, CarType,Employee, Project, TripTicket, User};
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Carbon;

class CreateTripTicket
{
    use AsAction;

    public function handle(User $user, Employee $employee, CarType $carType, Project $project, Account $account, Carbon $fromDataTime, Carbon $toDataTime, string $remarks): TripTicket
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
        $tripTicket->save();
        $tripTicket->setStatus('for approval','new request');

        return $tripTicket;
    }
}
