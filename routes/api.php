<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\WorkoutController;


Route::prefix('users')->group(function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::get('{id}', [ProfileController::class, 'show']);
    Route::put('{id}', [ProfileController::class, 'update']);
    Route::delete('{id}', [ProfileController::class, 'destroy']);
});


Route::post('/login', [ProfileController::class, 'login']);
Route::post('/register', [ProfileController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('exercises')->group(function () {
        Route::get('/', [ExerciseController::class, 'index']);
        Route::get('{id}', [ExerciseController::class, 'show']);
        Route::post('/', [ExerciseController::class, 'store']);
        Route::put('{id}', [ExerciseController::class, 'update']);
        Route::delete('{id}', [ExerciseController::class, 'destroy']);
    });


    Route::prefix('workouts')->group(function () {
        Route::get('/', [WorkoutController::class, 'index']);
        Route::get('{id}', [WorkoutController::class, 'show']);
        Route::post('/', [WorkoutController::class, 'store']);
        Route::put('{id}', [WorkoutController::class, 'update']);
        Route::delete('{id}', [WorkoutController::class, 'destroy']);
    });

    Route::middleware('auth:sanctum')->post('/logout', [ProfileController::class, 'logout']);
});
