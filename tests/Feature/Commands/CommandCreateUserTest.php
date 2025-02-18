<?php

use App\Models\User;

it('should create a user with the required arguments', function () {
    // Arrange
    $name = 'Test';
    $email = 'testuser@example.com';
    $password = 'password123';

    // Act
    $command = Artisan::call('user:create ' . $name . ' ' . $email . ' ' . $password);

    // Assert
    $this->assertStringContainsString('User created succesfully', Artisan::output());

    $user = User::where('email', $email)->first();
    $this->assertNotNull($user);
    $this->assertEquals($name, $user->name);
    $this->assertTrue(Hash::check($password, $user->password));
});

it('should create a user with a generated password if no password is provided', function () {
    // Arrange
    $name = 'Generated';
    $email = 'generateduser@example.com';

    // Act
    $command = Artisan::call('user:create ' . $name . ' ' . $email);

    // Assert
    $this->assertStringContainsString('User created succesfully', Artisan::output());

    $user = User::where('email', $email)->first();
    $this->assertNotNull($user);
    $this->assertEquals($name, $user->name);


    $this->assertNotEquals($user->password, 'password123');
});

it('should fail to create a user with a duplicate email', function () {
    // Arrange
    $existingUser = User::factory()->create([
        'email' => 'duplicate@example.com',
    ]);
    $name = 'NewUser';
    $email = 'duplicate@example.com';

    // Act
    $command = Artisan::call('user:create ' . $name . ' ' . $email);

    // Assert
    $this->assertStringContainsString('The email is already taken.', Artisan::output());


    $user = User::where('email', $email)->first();
    $this->assertEquals($existingUser->id, $user->id);
});


