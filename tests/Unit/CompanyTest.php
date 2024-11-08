<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Company;

uses(RefreshDatabase::class, WithFaker::class);

test('company has attributes', function () {
    $company = Company::factory()->create();
    expect($company->id)->toBeInt();
    expect($company->name)->toBeString();
});

test('company has fillables', function () {
    $name = $this->faker->name();
    $company = Company::create(compact('name', ));
    expect($company->name)->toBe($name);
});
