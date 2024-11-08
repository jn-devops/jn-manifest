<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Account;

uses(RefreshDatabase::class, WithFaker::class);

test('account has attributes', function () {
    $account = Account::factory()->create();
    expect($account->id)->toBeInt();
    expect($account->code)->toBeString();
    expect($account->name)->toBeString();
    expect($account->description)->toBeString();
});

test('account has fillables', function () {
    $code = $this->faker->word();
    $name = $this->faker->name();
    $description = $this->faker->sentence();
    $account = Account::create(compact('code', 'name', 'description'));
    expect($account->code)->toBe($code);
    expect($account->name)->toBe($name);
    expect($account->description)->toBe($description);
});
