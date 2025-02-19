<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('shows the profile edit page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('profile.edit'));

    $response->assertStatus(200);
    $response->assertViewIs('profile.edit');
});

it('updates the profile with new data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $updatedData = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
    ];

    $response = $this->put(route('profile.update'), $updatedData);

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('users', [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);

    $user->refresh();
    expect(Hash::check('newpassword', $user->password))->toBeTrue();
});

it('does not update with invalid data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $invalidData = [
        'name' => '', // Invalid
        'email' => 'invalid-email', // Invalid
        'password' => 'short', // Invalid
    ];

    $response = $this->put(route('profile.update'), $invalidData);

    $response->assertSessionHasErrors(['name', 'email', 'password']);
});

it('deletes the user account', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->delete("/profile/delete");

    $response->assertRedirect(route('index'));

    $this->assertGuest();

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});


it('deletes the user profile image', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Storage::fake('public');

    $file = UploadedFile::fake()->image('profile.jpg');
    $user->profile_photo = $file->store('profile_photos', 'public');
    $user->save();

    Storage::disk('public')->assertExists($user->profile_photo);

    $response = $this->delete(route('profile.destroyImage'));

    $response->assertRedirect(route('dashboard'));

    $this->assertDatabaseMissing('users', ['profile_photo' => $user->profile_photo]);

    Storage::disk('public')->assertMissing($user->profile_photo);
});


it('returns an error if there is no profile photo to delete', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->delete(route('profile.destroyImage'));

    $response->assertRedirect(route('dashboard'));
    $response->assertSessionHas('error', 'No se encontró ninguna foto de perfil para eliminar.');
});

