<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;

uses(RefreshDatabase::class, WithFaker::class);

test('project has attributes', function () {
    $project = Project::factory()->create();
    expect($project->id)->toBeInt();
    expect($project->code)->toBeString();
    expect($project->name)->toBeString();
    expect($project->description)->toBeString();
});

test('project has fillables', function () {
    $code = $this->faker->word();
    $name = $this->faker->name();
    $description = $this->faker->sentence();
    $project = Project::create(compact('code', 'name', 'description'));
    expect($project->code)->toBe($code);
    expect($project->name)->toBe($name);
    expect($project->description)->toBe($description);
});
