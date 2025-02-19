<?php

use App\Models\User;
use App\Models\Exercise;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists all exercises', function () {
    $user = User::factory()->create();
    Exercise::factory()->count(3)->create([
        'user_id' => $user->id
        ]
    );

    $response = $this->get(route('famous-workouts'));

    $response->assertStatus(200);
    $response->assertViewHas('exercises');
});

it('shows a single exercise', function () {
    $user = User::factory()->create();

    $exercise = Exercise::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->get(route('exercise.show', $exercise->id));

    $response->assertStatus(200);
    $response->assertViewHas('exercise', $exercise);
});


it('stores an exercise', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $exerciseData = [
        'title' => 'Push-up',
        'description' => 'A basic upper body exercise',
        'media' => null,
        'youtube_video_id' => null,
    ];

    $response = $this->post(route('exercise.store'), $exerciseData);

    $response->assertRedirect(route('famous-workouts'));
    $this->assertDatabaseHas('exercises', [
        'title' => 'Push-up',
        'description' => 'A basic upper body exercise',
    ]);
});

it('returns a list of exercises for search', function () {
    $user = User::factory()->create();

    $exercise = Exercise::factory()->create([
        'title' => 'Push-up',
        'user_id' => $user->id,
    ]);

    $response = $this->get(route('search-workouts', ['q' => 'Push-up']));
    $response->assertStatus(200);
    $response->assertJsonFragment(['title' => 'Push-up']);
});

it('allows users to edit their own exercises', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    $response = $this->get(route('exercise.edit', $exercise->id));

    $response->assertStatus(200);
    $response->assertViewHas('exercise', $exercise);
});

it('updates an exercise', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    $updatedData = [
        'title' => 'Updated Exercise',
        'description' => 'Updated description',
        'media' => null,
        'youtube_video_id' => null,
    ];

    $response = $this->put(route('exercise.update', $exercise->id), $updatedData);

    $response->assertRedirect(route('exercise.show', $exercise->id));
    $this->assertDatabaseHas('exercises', [
        'title' => 'Updated Exercise',
        'description' => 'Updated description',
    ]);
});

it('deletes an exercise', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    $response = $this->delete(route('exercise.destroy', $exercise->id));

    $response->assertRedirect(route('famous-workouts'));
    $this->assertDatabaseMissing('exercises', ['id' => $exercise->id]);
});
