<?php

use App\Models\User;

it('should create an exercise when authenticated with correct credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->artisan('exercise:create')
        ->expectsQuestion('Escribe el correo electronico', $user->email)
        ->expectsQuestion('Escribe la contraseña', 'password123') // Provide the plain password
        ->expectsOutput("Loggued as {$user->name}")
        ->expectsQuestion('Escribe el titulo del ejercicio', 'New Exercise')
        ->expectsQuestion('Escribe la descripcion del ejercicio', 'Exercise Description')
        ->expectsQuestion('Escribe la ruta de la imagen que quieres que se vea reflejada (opcional)', 'media_url')
        ->expectsQuestion('Escribe el id del tutorial de youtube (opcional)', 'youtube_id')
        ->assertExitCode(0);

    $this->assertDatabaseHas('exercises', [
        'title' => 'New Exercise',
        'description' => 'Exercise Description',
        'media' => 'media_url',
        'youtube_video_id' => 'youtube_id',
        'user_id' => $user->id,
    ]);

});

it('should fail to create an exercise with incorrect credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->artisan('exercise:create')
        ->expectsQuestion('Escribe el correo electronico', $user->email)
        ->expectsQuestion('Escribe la contraseña', '123456789')
        ->expectsOutput('Incorrect credentials.')
        ->assertExitCode(1);
});

it('should fail to create an exercise without title argument', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->artisan('exercise:create')
        ->expectsQuestion('Escribe el correo electronico', $user->email)
        ->expectsQuestion('Escribe la contraseña', 'password123')
        ->expectsOutput("Loggued as {$user->name}")
        ->expectsQuestion('Escribe el titulo del ejercicio', '')
        ->expectsQuestion('Escribe la descripcion del ejercicio', 'Description')
        ->expectsQuestion('Escribe la ruta de la imagen que quieres que se vea reflejada (opcional)', 'media_url')
        ->expectsQuestion('Escribe el id del tutorial de youtube (opcional)', 'youtube_id')
        ->expectsOutput('Title and description is required.')
        ->assertExitCode(1);
});
