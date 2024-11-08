<?php

use App\Notifications\{ApprovedNotification, ForApprovalNotification, ForRevisionNotification, RejectedNotification};
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Company, Department, Employee};
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;

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
    $mobile = '09171234567';
    $employee = Employee::create(compact('name', 'email', 'mobile'));
    expect($employee->name)->toBe($name);
    expect($employee->email)->toBe($email);
    expect($employee->mobile)->toBe(phone($mobile, 'PH', \libphonenumber\PhoneNumberFormat::NATIONAL));
});

test('employee has company relation', function () {
    $employee = Employee::factory()->create(['mobile' => '09171234567']);
    $company = Company::factory()->create();
    $employee->company()->associate($company);
    expect($employee->company->is($company))->toBeTrue();
});

test('employee has department relation', function () {
    $employee = Employee::factory()->create(['mobile' => '09171234567']);
    $department = Department::factory()->create();
    $employee->department()->associate($department);
    expect($employee->department->is($department))->toBeTrue();
});

test('employee has notifications', function () {
    Notification::fake();
    $employee = Employee::factory()->create(['mobile' => '09171234567']);
    $employee->notify(new ForApprovalNotification);
    $employee->notify(new RejectedNotification);
    $employee->notify(new ForRevisionNotification);
    $employee->notify(new ApprovedNotification);
    Notification::assertSentTo($employee, ForApprovalNotification::class);
    Notification::assertSentTo($employee, RejectedNotification::class);
    Notification::assertSentTo($employee, ForRevisionNotification::class);
    Notification::assertSentTo($employee, ApprovedNotification::class);
});

test('employee has mobile format', function () {
    $employee = Employee::factory()->create(['mobile' => '09173011987']);
});
