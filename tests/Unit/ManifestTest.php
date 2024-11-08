<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\{Manifest, TripTicket, User};

uses(RefreshDatabase::class, WithFaker::class);

test('manifest has attributes', function () {
    $manifest = Manifest::factory()->for(TripTicket::factory()->forUser())->create();
    expect($manifest->id)->toBeInt();
    expect($manifest->name)->toBeString();
    expect($manifest->passenger_type)->toBeString();
});

test('manifest has fillables', function () {
    $name = $this->faker->name();
    $passenger_type = $this->faker->sentence();
    $manifest = Manifest::make(compact('name', 'passenger_type'));
    $user = User::factory()->create();
    $trip_ticket = TripTicket::factory()->make();
    $trip_ticket->user()->associate($user);
    $manifest->tripTicket()->associate($trip_ticket);
    expect($manifest->name)->toBe($name);
    expect($manifest->passenger_type)->toBe($passenger_type);
});