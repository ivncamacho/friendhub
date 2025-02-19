<?php

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('should return a list of workouts', function () {
    $user = User::factory()->create();
    $workouts = Workout::factory(3)->create(['user_id' => $user->id]);
    $this->actingAs($user, 'sanctum');
    $response = $this->getJson('/api/workouts');
    $response->assertStatus(200);
    $response->assertJsonCount(3);
    $response->assertJsonStructure([
        '*' => ['id', 'title', 'user_id', 'description', 'created_at'],
    ]);
});

it('should return a specific workout', function () {
    $user = User::factory()->create();
    $workout = Workout::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user, 'sanctum');
    $response = $this->getJson("/api/workouts/{$workout->id}");
    $response->assertStatus(200);
    $response->assertJsonFragment([
        'id' => $workout->id,
        'title' => $workout->title,
        'user_id' => $workout->user_id,
        'description' => $workout->description,
    ]);
});

it('should create a workout', function () {

    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');


    $exercise1 = Exercise::factory()->create();
    $exercise2 = Exercise::factory()->create();
    $exercise3 = Exercise::factory()->create();

    // Datos para el entrenamiento
    $data = [
        'title' => 'New Workout',
        'description' => 'Description of the workout',
        'exercises' => [
            ['exercise_id' => $exercise1->id, 'sets' => 3, 'reps' => 10], // Incluir 'sets' y 'reps'
            ['exercise_id' => $exercise2->id, 'sets' => 4, 'reps' => 12],
            ['exercise_id' => $exercise3->id, 'sets' => 5, 'reps' => 8],
        ],
    ];


    $response = $this->postJson('/api/workouts', $data);


    $response->assertStatus(201);
    $response->assertJson([
        'message' => 'Entrenamiento creado con éxito',
    ]);


    $this->assertDatabaseHas('workouts', [
        'title' => 'New Workout',
        'description' => 'Description of the workout',
        'user_id' => $user->id,
    ]);

    $workout = Workout::first();
    $this->assertCount(3, $workout->exercises);

    $this->assertDatabaseHas('workout_exercises', [
        'workout_id' => $workout->id,
        'exercise_id' => $exercise1->id,
        'sets' => 3,
        'reps' => 10,
    ]);
    $this->assertDatabaseHas('workout_exercises', [
        'workout_id' => $workout->id,
        'exercise_id' => $exercise2->id,
        'sets' => 4,
        'reps' => 12,
    ]);
    $this->assertDatabaseHas('workout_exercises', [
        'workout_id' => $workout->id,
        'exercise_id' => $exercise3->id,
        'sets' => 5,
        'reps' => 8,
    ]);
});

it('should update a workout', function () {
    $user = User::factory()->create();
    $workout = Workout::factory()->create(['user_id' => $user->id]);


    $exercise1 = Exercise::factory()->create();
    $exercise2 = Exercise::factory()->create();

    $data = [
        'title' => 'Updated Workout',
        'description' => 'Updated description',
        'exercises' => [
            ['exercise_id' => $exercise1->id, 'sets' => 3, 'reps' => 10],  // Usar el ID del ejercicio creado
            ['exercise_id' => $exercise2->id, 'sets' => 4, 'reps' => 12],  // Usar el ID del ejercicio creado
        ],
    ];

    $this->actingAs($user, 'sanctum');
    $response = $this->putJson("/api/workouts/{$workout->id}", $data);
    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Entrenamiento actualizado correctamente',
    ]);


    $this->assertDatabaseHas('workouts', [
        'id' => $workout->id,
        'title' => 'Updated Workout',
        'description' => 'Updated description',
    ]);
});

it('should delete a workout', function () {
    $user = User::factory()->create();

    $workout = Workout::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user, 'sanctum');

    $response = $this->deleteJson("/api/workouts/{$workout->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Entrenamiento eliminado correctamente',
    ]);

    $this->assertDatabaseMissing('workouts', [
        'id' => $workout->id,
    ]);
});
