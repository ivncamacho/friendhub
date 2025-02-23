<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('should return all users', function () {
    // Crear algunos usuarios para la prueba
    $users = User::factory(3)->create();

    $response = $this->getJson('/api/users');

    $response->assertStatus(200);

    $response->assertJsonCount(3);
    $response->assertJsonStructure([
        '*' => ['id', 'name', 'email'],
    ]);
});

it('should create a user successfully', function () {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/register', $userData);

    $response->assertStatus(201);
    $response->assertJson([
        'message' => 'Usuario creado correctamente',
        'user' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ],
    ]);
});

it('should update a user successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $updatedData = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ];

    $response = $this->putJson("/api/users/{$user->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Usuario actualizado correctamente',
        'user' => [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ],
    ]);
});

it('should not update another user without permission', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $this->actingAs($user1, 'sanctum');

    $updatedData = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ];

    $response = $this->putJson("/api/users/{$user2->id}", $updatedData);

    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'You do not have permission to perform this action.',
    ]);
});

it('should delete a user successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $response = $this->deleteJson("/api/users/{$user->id}");

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Usuario eliminado correctamente']);
});

it('should not delete another user without permission', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $this->actingAs($user1, 'sanctum');

    $response = $this->deleteJson("/api/users/{$user2->id}");

    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'You do not have permission to perform this action.',
    ]);
});

it('should login successfully', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'token',
        'user' => [
            'name',
            'email',
        ],
    ]);
});

it('should not login with invalid credentials', function () {
    $response = $this->postJson('/api/login', [
        'email' => 'wrong@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401);
    $response->assertJson(['message' => 'Credenciales incorrectas']);
});

it('should logout successfully', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Sesión cerrada correctamente']);
});

it('should show a user profile', function () {
    $user = User::factory()->create();

    $response = $this->getJson("/api/users/{$user->id}");

    $response->assertStatus(200);
    $response->assertJson([
        'name' => $user->name,
        'email' => $user->email,
    ]);
});

it('should return a 404 when user not found', function () {
    $response = $this->getJson('/api/profile/99999'); // Non-existing user ID

    $response->assertStatus(404);
});
