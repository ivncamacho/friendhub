<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');
Route::get('/famous-workouts', [ExerciseController::class, 'index'])->name('famous-workouts'); 
Route::get('/exercise/{id}', [ExerciseController::class, 'show'])->name('exercise.show');

Route::middleware('auth')->group(function () {

    Route::get('/feed', [WorkoutController::class, 'index'])->name('feed');
    Route::get('/workouts/create', [WorkoutController::class, 'create'])->name('workouts.create');
    Route::get('/workouts/{id}', [WorkoutController::class, 'show'])->name('workouts.show');
    Route::post('/workouts', [WorkoutController::class, 'store'])->name('workouts.store');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/destroyImage', [ProfileController::class, 'destroyImage'])->name('profile.destroyImage');

    Route::get('/myworkouts', [WorkoutController::class, 'myWorkouts'])->name('myworkouts');

    Route::get('/workouts/{id}/edit', [WorkoutController::class, 'edit'])->name('workouts.edit');
    Route::put('/workouts/{id}', [WorkoutController::class, 'update'])->name('workouts.update');
    Route::delete('/workoutsFeed/{id}', [WorkoutController::class, 'destroyFeed'])->name('workouts.destroyFeed');
    Route::delete('/workoutsMy/{id}', [WorkoutController::class, 'destroyMy'])->name('workouts.destroyMy');
    Route::get('/workouts/pdf/{id}', [WorkoutController::class, 'GeneratePDF'])->name('workout.pdf');

    Route::get('/exercises/create', [ExerciseController::class, 'create'])->name('exercise.create');
    Route::post('/exercises', [ExerciseController::class, 'store'])->name('exercise.store');
    Route::get('/exercises/{id}/edit', [ExerciseController::class, 'edit'])->name('exercise.edit');
    Route::put('/exercises/{id}', [ExerciseController::class, 'update'])->name('exercise.update');
    Route::delete('/exercises/{id}', [ExerciseController::class, 'destroy'])->name('exercise.destroy');
});

require __DIR__.'/auth.php';
