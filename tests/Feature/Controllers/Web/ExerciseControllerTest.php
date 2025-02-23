<?php

use App\Models\User;
use App\Models\Exercise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


it('shows the exercise creation page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('exercise.create'));

    $response->assertStatus(200);
    $response->assertViewIs('exercise.create');
});



it('lists all exercises', function () {
    $user = User::factory()->create();
    Exercise::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->get(route('famous-workouts'));

    $response->assertStatus(200);
    $response->assertViewHas('exercises');
});

it('shows a single exercise', function () {
    $user = User::factory()->create();
    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

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

it('stores an exercise with an image', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Storage::fake('public');
    $file = UploadedFile::fake()->image('exercise.jpg');

    $exerciseData = [
        'title' => 'Squat',
        'description' => 'A lower body exercise',
        'media' => $file,
        'youtube_video_id' => null,
    ];

    $response = $this->post(route('exercise.store'), $exerciseData);

    $response->assertRedirect(route('famous-workouts'));

    $exercise = Exercise::where('title', 'Squat')->first();

    expect($exercise)->not->toBeNull();
    expect($exercise->media)->not->toBeNull();

    $filePath = public_path("assets/img/exercises/{$exercise->media}");
    expect(file_exists($filePath))->toBeTrue();
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

it('does not allow a user to delete someone else\'s exercise', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $exercise = Exercise::factory()->create(['user_id' => $user1->id]);
    $this->actingAs($user2);

    $response = $this->delete(route('exercise.destroy', $exercise->id));
    $response->assertForbidden();
    $this->assertDatabaseHas('exercises', ['id' => $exercise->id]);
});

it('deletes an exercise successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $exercise = Exercise::factory()->create(['user_id' => $user->id]);
    $response = $this->delete(route('exercise.destroy', $exercise->id));

    $response->assertRedirect(route('famous-workouts'));
    $this->assertDatabaseMissing('exercises', ['id' => $exercise->id]);
});

// Tests adicionales para alcanzar el 100% de cobertura

it('validates required fields when creating an exercise', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('exercise.store'), [
        'title' => '', // Faltan campos requeridos
        'description' => '',
        'media' => null,
        'youtube_video_id' => null,
    ]);

    $response->assertSessionHasErrors(['title', 'description']);
});

it('does not allow users to edit exercises that do not belong to them', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $exercise = Exercise::factory()->create(['user_id' => $user1->id]);

    $this->actingAs($user2);

    $response = $this->get(route('exercise.edit', $exercise->id));

    $response->assertForbidden();
});

it('does not allow users to delete exercises that do not belong to them', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $exercise = Exercise::factory()->create(['user_id' => $user1->id]);

    $this->actingAs($user2);

    $response = $this->delete(route('exercise.destroy', $exercise->id));

    $response->assertForbidden();
    $this->assertDatabaseHas('exercises', ['id' => $exercise->id]);
});

it('does not allow invalid image file types', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Storage::fake('public');
    $file = UploadedFile::fake()->create('invalid_file.txt', 100);

    $exerciseData = [
        'title' => 'Invalid Image',
        'description' => 'This should fail',
        'media' => $file,
        'youtube_video_id' => null,
    ];

    $response = $this->post(route('exercise.store'), $exerciseData);

    $response->assertSessionHasErrors(['media']);
});

it('does not create an exercise if the image validation fails', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $exerciseData = [
        'title' => 'Exercise without Image',
        'description' => 'Description without an image',
        'media' => 'invalid_file.txt', // Esto no es una imagen válida
        'youtube_video_id' => null,
    ];

    $response = $this->post(route('exercise.store'), $exerciseData);

    $response->assertSessionHasErrors(['media']);
    $this->assertDatabaseMissing('exercises', ['title' => 'Exercise without Image']);
});

it('redirects unauthenticated users when storing an exercise', function () {
    $exerciseData = [
        'title' => 'Exercise for unauthenticated users',
        'description' => 'This should not work',
        'media' => null,
        'youtube_video_id' => null,
    ];

    $response = $this->post(route('exercise.store'), $exerciseData);

    $response->assertRedirect(route('login'));
});

it('updates an exercise with a new image', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $exercise = Exercise::factory()->create(['user_id' => $user->id]);

    Storage::fake('public');
    $file = UploadedFile::fake()->image('updated_exercise.jpg');

    $updatedData = [
        'title' => 'Updated Exercise',
        'description' => 'Updated description',
        'media' => $file,
        'youtube_video_id' => null,
    ];

    $response = $this->put(route('exercise.update', $exercise->id), $updatedData);

    $response->assertRedirect(route('exercise.show', $exercise->id));
    $this->assertDatabaseHas('exercises', [
        'title' => 'Updated Exercise',
        'description' => 'Updated description',
    ]);

    // Verifica que el archivo se haya subido
    $exercise = Exercise::find($exercise->id);
    expect($exercise->media)->not->toBeNull();

    // Verifica que el archivo haya sido guardado en la ubicación correcta
    $filePath = public_path("assets/img/exercises/{$exercise->media}");
    expect(file_exists($filePath))->toBeTrue();
});

