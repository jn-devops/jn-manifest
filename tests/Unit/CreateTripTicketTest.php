<?php

use App\Models\{Account, CarType, Employee, Project, TripTicket, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Actions\CreateTripTicket;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class, WithFaker::class);

test('create trip ticket works', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create(['mobile' => '09171234567']);
    $carType = CarType::factory()->create();
    $project = Project::factory()->create();
    $account = Account::factory()->create();
    $fromDateTime = Carbon::now();
    $toDateTime = Carbon::now();
    $remarks = $this->faker->sentence();
    $location = $this->faker->address();

    $trip_ticket = app(CreateTripTicket::class)->run($user, $employee, $carType, $project, $account, $fromDateTime, $toDateTime, $remarks,$location);
    expect($trip_ticket)->toBeInstanceOf(TripTicket::class);
    expect($trip_ticket->user->is($user))->toBeTrue();
    expect($trip_ticket->employee->is($employee))->toBeTrue();
    expect($trip_ticket->carType->is($carType))->toBeTrue();
    expect($trip_ticket->project->is($project))->toBeTrue();
    expect($trip_ticket->account->is($account))->toBeTrue();
    expect($trip_ticket->fromDateTime->is($fromDateTime))->toBeTrue();
    expect($trip_ticket->toDateTime->is($toDateTime))->toBeTrue();
    expect($trip_ticket->remarks)->toBe($remarks);
    expect($trip_ticket->location)->toBe($location);
    expect($trip_ticket->status)->toBe('For Approval');
});
