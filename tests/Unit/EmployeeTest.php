<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Company, Department, Employee};
use Illuminate\Foundation\Testing\WithFaker;

uses(RefreshDatabase::class, WithFaker::class);

test('employee has attributes', function () {
    $employee = Employee::factory()->create();
    expect($employee->id)->toBeInt();
    expect($employee->name)->toBeString();
    expect($employee->email)->toBeString();
    expect($employee->mobile)->toBeString();
});

test('employee has fillables', function () {
    $name = $this->faker->name();
    $email = $this->faker->email();
    $mobile = $this->faker->phoneNumber();
    $employee = Employee::create(compact('name', 'email', 'mobile'));
    expect($employee->name)->toBe($name);
    expect($employee->email)->toBe($email);
    expect($employee->mobile)->toBe($mobile);
});

test('employee has company relation', function () {
    $employee = Employee::factory()->create();
    $company = Company::factory()->create();
    $employee->company()->associate($company);
    expect($employee->company->is($company))->toBeTrue();
});

test('employee has department relation', function () {
    $employee = Employee::factory()->create();
    $department = Department::factory()->create();
    $employee->department()->associate($department);
    expect($employee->department->is($department))->toBeTrue();
});
