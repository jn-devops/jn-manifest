<?php

use App\Models\{Account, Employee, Manifest, Project, TripTicket, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses(RefreshDatabase::class, WithFaker::class);

test('trip ticket has attributes', function () {
    $trip_ticket = TripTicket::factory()->forUser()->create();
    expect($trip_ticket->id)->toBeInt();
    expect($trip_ticket->code)->toBeString();
    expect(strlen($trip_ticket->code))->toBe(8);
    expect($trip_ticket->status)->toBeString();
    expect($trip_ticket->remarks)->toBeString();
    expect($trip_ticket->location)->toBeString();
});

test('trip ticket has fillables', function () {
    $status = $this->faker->word();
    $remarks = $this->faker->sentence();
    $trip_ticket = TripTicket::make(compact('status', 'remarks'));
    $trip_ticket->user()->associate(User::factory()->create());
    $trip_ticket->save();
    expect($trip_ticket->remarks)->toBe($remarks);
});

test('trip ticket has user relation', function () {
    $user = User::factory()->create();
    $trip_ticket = TripTicket::factory()->make();
    $trip_ticket->user()->associate($user);
    expect($trip_ticket->user->is($user))->toBeTrue();
});

test('trip ticket has employee relation', function () {
    $employee = Employee::factory()->create(['mobile' => '09171234567']);
    $trip_ticket = TripTicket::factory()->forUser()->make();
    $trip_ticket->employee()->associate($employee);
    expect($trip_ticket->employee->is($employee))->toBeTrue();
});

test('trip ticket has project relation', function () {
    $project = Project::factory()->create();
    $trip_ticket = TripTicket::factory()->forUser()->make();
    $trip_ticket->project()->associate($project);
    expect($trip_ticket->project->is($project))->toBeTrue();
});

test('trip ticket has account relation', function () {
    $account = Account::factory()->create();
    $trip_ticket = TripTicket::factory()->forUser()->make();
    $trip_ticket->account()->associate($account);
    expect($trip_ticket->account->is($account))->toBeTrue();
});

test('trip ticket has many manifests', function () {
    $trip_ticket = TripTicket::factory()->forUser()->create();
    expect($trip_ticket->manifests)->toHaveCount(0);
    $name = $this->faker->name();
    $passenger_type = $this->faker->sentence();
    $manifest = Manifest::factory()->create();
    $manifest->trip_ticket()->associate($trip_ticket);
    $trip_ticket->manifests()->save(Manifest::factory()->create());
    $manifest = Manifest::factory()->create();
    $manifest->trip_ticket()->associate($trip_ticket);
    $trip_ticket->manifests()->save(Manifest::factory()->create());
    $trip_ticket->manifests()->create(compact('name', 'passenger_type'));
    $trip_ticket->refresh();
    expect($trip_ticket->manifests)->toHaveCount(3);
});
