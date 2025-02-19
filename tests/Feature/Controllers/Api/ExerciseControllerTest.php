<?php

use App\Events\ExercisePublished;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

it('should list all exercises', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    Exercise::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->getJson('/api/exercises');

    $response->assertStatus(200)->assertJsonCount(3);
});


it('should show a specific exercise', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    $response = $this->getJson("/api/exercises/{$exercise->id}");

    $response->assertStatus(200)->assertJson(['id' => $exercise->id]);
});


it('should create an exercise and dispatch ExercisePublished event', function () {
    Event::fake();

    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/exercises', [
        'title' => 'New Exercise',
        'description' => 'Exercise description',
        'media' => 'example.jpg',
        'youtube_video_id' => 'xyz123'
    ]);

    $response->assertStatus(201)->assertJsonStructure(['message', 'exercise']);

    Event::assertDispatched(ExercisePublished::class);
});

it('should update an exercise', function () {
    $user = User::factory()->create();
    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->putJson("/api/exercises/{$exercise->id}", [
        'title' => 'Updated Title',
        'description' => 'Updated description',
        'media' => 'updated.jpg',
        'youtube_video_id' => 'abc456'
    ]);

    $response->assertStatus(200)->assertJsonFragment(['title' => 'Updated Title']);
});

it('should delete an exercise', function () {
    $user = User::factory()->create();
    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->deleteJson("/api/exercises/{$exercise->id}");

    $response->assertStatus(200)->assertJson(['message' => 'Ejercicio eliminado correctamente']);
    $this->assertDatabaseMissing('exercises', ['id' => $exercise->id]);
});
