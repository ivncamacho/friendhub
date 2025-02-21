<?php

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Events\WorkoutPublished;


it('shows the workout create page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('workouts.create'));

    $response->assertStatus(200);
    $response->assertViewIs('workouts.create');
    $response->assertViewHas('exercises');
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

it('stores a workout', function () {
    Event::fake();
    $user = User::factory()->create();
    $this->actingAs($user);
    $exercises = Exercise::factory()->count(3)->create();
    $workoutData = [
        'title' => 'Test Workout',
        'description' => 'Test Description',
        'exercises' => $exercises->map(function ($exercise) {
            return [
                'exercise_id' => $exercise->id,
                'sets' => 3,
                'reps' => 10,
            ];
        })->toArray(),
    ];

    $response = $this->post(route('workouts.store'), $workoutData);

    $response->assertRedirect(route('feed'));
    $this->assertDatabaseHas('workouts', [
        'title' => 'Test Workout',
        'description' => 'Test Description',
        'user_id' => $user->id,
    ]);
    $this->assertDatabaseHas('workout_exercises', [
        'workout_id' => Workout::first()->id,
        'exercise_id' => $exercises->first()->id,
        'sets' => 3,
        'reps' => 10,
    ]);
    Event::assertDispatched(WorkoutPublished::class);
});

it('shows my workouts', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    Workout::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->get(route('myworkouts'));

    $response->assertStatus(200);
    $response->assertViewHas('workouts');
});

it('shows the workout edit page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $workout = Workout::factory()->create(['user_id' => $user->id]);

    $response = $this->get(route('workouts.edit', $workout->id));

    $response->assertStatus(200);
    $response->assertViewIs('workouts.edit');
    $response->assertViewHas('workout');
    $response->assertViewHas('exercises');
});

it('updates a workout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $workout = Workout::factory()->create(['user_id' => $user->id]);
    $exercises = Exercise::factory()->count(3)->create();
    $updateData = [
        'title' => 'Updated Title',
        'description' => 'Updated Description',
        'exercises' => $exercises->map(function ($exercise) {
            return [
                'exercise_id' => $exercise->id,
                'sets' => 3,
                'reps' => 10,
            ];
        })->toArray(),
    ];

    $response = $this->put(route('workouts.update', $workout->id), $updateData);

    $response->assertRedirect(route('workouts.show', $workout->id));
    $this->assertDatabaseHas('workouts', [
        'id' => $workout->id,
        'title' => 'Updated Title',
        'description' => 'Updated Description',
    ]);
    $this->assertDatabaseHas('workout_exercises', [
        'workout_id' => $workout->id,
        'exercise_id' => $exercises->first()->id,
        'sets' => 3,
        'reps' => 10,
    ]);
});

it('deletes a workout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $workout = Workout::factory()->create(['user_id' => $user->id]);

    $response = $this->delete(route('workouts.destroyFeed', $workout->id));

    $response->assertRedirect(route('feed'));
    $this->assertDatabaseMissing('workouts', ['id' => $workout->id]);
});

it('generates a PDF for a workout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $workout = Workout::factory()->create(['user_id' => $user->id]);

    $response = $this->get(route('workout.pdf', $workout->id));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});
