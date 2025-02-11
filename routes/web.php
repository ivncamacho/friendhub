<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

// Páginas accesibles sin iniciar sesión
Route::view('/', 'index')->name('index'); // Página principal
Route::get('/famous-workouts', [ExerciseController::class, 'index'])->name('famous-workouts'); // Ejercicios comunes
Route::get('/exercise/{id}', [ExerciseController::class, 'show'])->name('exercise.show'); // Ver detalle ejercicio
Route::get('/login', function () {
    return view('auth.login'); // Vista login
})->name('login');
Route::get('/register', function () {
    return view('auth.register'); // Vista registro
})->name('register');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Página de feed y creación de entrenamientos
    Route::get('/feed', [WorkoutController::class, 'index'])->name('feed');
    Route::get('/workouts/create', [WorkoutController::class, 'create'])->name('workouts.create');
    Route::get('/workouts/{id}', [WorkoutController::class, 'show'])->name('workouts.show');
    Route::post('/workouts', [WorkoutController::class, 'store'])->name('workouts.store');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Mis entrenamientos
    Route::get('/myworkouts', [WorkoutController::class, 'myWorkouts'])->name('myworkouts');

    // Rutas de creación de ejercicios
    Route::get('/exercises/create', [ExerciseController::class, 'create'])->name('exercise.create');
    Route::post('/exercises', [ExerciseController::class, 'store'])->name('exercise.store');
});

// Rutas de búsqueda de entrenamientos (sin autenticación)
Route::get('/search-workouts', [ExerciseController::class, 'search'])->name('search-workouts');

// Rutas de entrenamientos (con protección para editar y eliminar)
Route::middleware('auth')->group(function () {
    // Editar, actualizar y eliminar entrenamientos
    Route::get('/workouts/{id}/edit', [WorkoutController::class, 'edit'])->name('workouts.edit');
    Route::put('/workouts/{id}', [WorkoutController::class, 'update'])->name('workouts.update');
    Route::delete('/workouts/{id}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');

    // Editar, actualizar y eliminar ejercicios
    Route::get('/exercises/{id}/edit', [ExerciseController::class, 'edit'])->name('exercise.edit');
    Route::put('/exercises/{id}', [ExerciseController::class, 'update'])->name('exercise.update');
    Route::delete('/exercises/{id}', [ExerciseController::class, 'destroy'])->name('exercise.destroy');
});


// Requerir rutas de autenticación
require __DIR__.'/auth.php';
