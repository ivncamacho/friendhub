<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('should create a user with the required arguments', function () {
    // Arrange
    $name = 'Test';
    $email = 'testuser@example.com';
    $password = 'password123';

    // Act
    $this->artisan('user:create')
        ->expectsQuestion('Escribe el nombre de usuario', $name)
        ->expectsQuestion('Escribe el correo electronico', $email)
        ->expectsQuestion('Escribe la contraseña', $password)
        ->assertExitCode(0);

    // Assert
    $user = User::where('email', $email)->first();
    $this->assertNotNull($user);
    $this->assertEquals($name, $user->name);
    $this->assertTrue(Hash::check($password, $user->password));
});

it('should fail to create a user with a duplicate name', function () {
    // Arrange
    $existingUser = User::factory()->create([
        'name' => 'duplicate',
    ]);
    $name = 'duplicate';
    $email = 'newuser@example.com';
    $password = '12345678';

    // Act
    $this->artisan('user:create')
        ->expectsQuestion('Escribe el nombre de usuario', $name)
        ->expectsQuestion('Escribe el correo electronico', $email)
        ->expectsQuestion('Escribe la contraseña', $password)
        ->assertExitCode(1);

    // Assert
    $user = User::where('name', $name)->first();
    $this->assertEquals($existingUser->id, $user->id);
});

it('should fail to create a user with a duplicate email', function () {
    // Arrange
    $existingUser = User::factory()->create([
        'email' => 'duplicate@example.com',
    ]);
    $name = 'NewUser';
    $email = 'duplicate@example.com';
    $password = '12345678';

    // Act
    $this->artisan('user:create')
        ->expectsQuestion('Escribe el nombre de usuario', $name)
        ->expectsQuestion('Escribe el correo electronico', $email)
        ->expectsQuestion('Escribe la contraseña', $password)
        ->assertExitCode(1);

    // Assert
    $user = User::where('email', $email)->first();
    $this->assertEquals($existingUser->id, $user->id);
});
