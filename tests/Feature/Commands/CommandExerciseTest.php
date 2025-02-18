<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

it('should create an exercise when authenticated with correct credentials', function () {
    // Arrange: Crea un usuario para autenticar
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    // Act: Ejecuta el comando como el usuario autenticado
    $command = Artisan::call('exercise:create test@example.com password123 "New Exercise" "Exercise Description" "media_url" "youtube_id"');

    // Assert: Verifica que el ejercicio fue creado
    $this->assertStringContainsString('Exercise \'New Exercise\' created succesfully.', Artisan::output());
});

it('should fail to create an exercise with incorrect credentials', function () {
    // Arrange: Crea un usuario para autenticar
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    // Act: Intenta ejecutar el comando con credenciales incorrectas
    $command = Artisan::call('exercise:create test@example.com wrongpassword "New Exercise" "Exercise Description" "media_url" "youtube_id"');

    // Assert: Verifica que el mensaje de error sea el esperado
    $this->assertStringContainsString('Incorrect credentials.', Artisan::output());
});

it('should fail to create an exercise without title argument', function () {
    // Arrange: Crea un usuario para autenticar
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    // Act: Ejecuta el comando sin el argumento 'title'
    $command = Artisan::call('exercise:create test@example.com password123 "" "Exercise Description" "media_url" "youtube_id"');

    // Assert: Verifica que el comando falle por falta de título
    $this->assertStringContainsString('title is required', Artisan::output());
});


it('should create exercise with optional arguments', function () {
    // Arrange: Crea un usuario para autenticar
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    // Act: Ejecuta el comando con los argumentos opcionales (description, media, youtube_video_id)
    $command = Artisan::call('exercise:create test@example.com password123 "New Exercise" "Exercise Description" "media_url" "youtube_id"');

    // Assert: Verifica que el ejercicio fue creado con los valores pasados
    $this->assertStringContainsString('Exercise \'New Exercise\' created succesfully.', Artisan::output());
});

it('should not create an exercise if the user is not authenticated', function () {
    // Act: Ejecuta el comando sin autenticarse
    $command = Artisan::call('exercise:create test@example.com wrongpassword "New Exercise" "Exercise Description" "media_url" "youtube_id"');

    // Assert: Verifica que el mensaje de error sea el esperado
    $this->assertStringContainsString('Incorrect credentials.', Artisan::output());
});
