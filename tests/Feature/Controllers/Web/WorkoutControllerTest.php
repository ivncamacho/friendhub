<?php

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;

it('shows the workout create page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('workouts.create'));

    $response->assertStatus(200);
    $response->assertViewIs('workouts.create');
});

it('lists all workouts', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    Workout::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->get(route('feed'));

    $response->assertStatus(200);
    $response->assertViewHas('workouts');
});

it('shows a workout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $workout = Workout::factory()->create(['user_id' => $user->id]);

    $response = $this->get(route('workouts.show', $workout->id));

    $response->assertStatus(200);
    $response->assertViewIs('workouts.show');
    $response->assertViewHas('workout');
});
