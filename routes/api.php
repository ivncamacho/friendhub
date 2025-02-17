<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\WorkoutController;

// Rutas para usuarios (sin autenticación)
Route::prefix('users')->group(function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::get('{id}', [ProfileController::class, 'show']);
    Route::put('{id}', [ProfileController::class, 'update']);
    Route::delete('{id}', [ProfileController::class, 'destroy']);
});

// Rutas de login y registro (sin autenticación)
Route::post('/login', [ProfileController::class, 'login']);
Route::post('/register', [ProfileController::class, 'store']);

// Rutas protegidas por el middleware auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('exercises')->group(function () {
        Route::get('/', [ExerciseController::class, 'index']); // Listar ejercicios
        Route::get('{id}', [ExerciseController::class, 'show']); // Ver un ejercicio
        Route::post('/', [ExerciseController::class, 'store']); // Crear un ejercicio
        Route::put('{id}', [ExerciseController::class, 'update']); // Actualizar ejercicio
        Route::delete('{id}', [ExerciseController::class, 'destroy']); // Eliminar ejercicio
    });


    Route::prefix('workouts')->group(function () {
        Route::get('/', [WorkoutController::class, 'index']); // Listar entrenamientos
        Route::get('{id}', [WorkoutController::class, 'show']); // Ver un entrenamiento
        Route::post('/', [WorkoutController::class, 'store']); // Crear un entrenamiento
        Route::put('{id}', [WorkoutController::class, 'update']); // Actualizar entrenamiento
        Route::delete('{id}', [WorkoutController::class, 'destroy']); // Eliminar entrenamiento
    });

    // Ruta de logout
    Route::middleware('auth:sanctum')->post('/logout', [ProfileController::class, 'logout']);
});
