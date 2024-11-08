<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Department;

uses(RefreshDatabase::class, WithFaker::class);

test('department has attributes', function () {
    $department = Department::factory()->create();
    expect($department->id)->toBeInt();
    expect($department->name)->toBeString();
});

test('department has fillables', function () {
    $name = $this->faker->name();
    $department = Department::create(compact('name'));
    expect($department->name)->toBe($name);
});
