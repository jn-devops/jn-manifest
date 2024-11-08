<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\CarType;

uses(RefreshDatabase::class, WithFaker::class);

test('car type has attributes', function () {
    $car_type = CarType::factory()->create();
    expect($car_type->id)->toBeInt();
    expect($car_type->name)->toBeString();
    expect($car_type->description)->toBeString();
    expect($car_type->capacity)->toBeInt();
});

test('car type has fillables', function () {
    $name = $this->faker->name();
    $description = $this->faker->sentence();
    $capacity = $this->faker->numberBetween(1,7);
    $car_type = CarType::create(compact('name', 'description', 'capacity'));
    expect($car_type->name)->toBe($name);
    expect($car_type->description)->toBe($description);
    expect($car_type->capacity)->toBe($capacity);
});
