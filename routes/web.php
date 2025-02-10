<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**Route::get('/', function () {
    return view('welcome');
});*/

Route::view('/', 'index')->name('index');

Route::get('/feed', function () {
    return view('feed.mainPage');
})->middleware(['auth', 'verified'])->name('feed');

Route::get('/famous-workouts', [ExerciseController::class, 'index'])
    ->name('famous-workouts');

Route::get('/exercise/{id}', [ExerciseController::class, 'show'])->name('exercise.show');

Route::get('/dashboard', function () {
    return view('
    dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Ruta para mostrar el formulario de creación
Route::get('/exercises/create', [ExerciseController::class, 'create'])->name('exercise.create');
// Ruta para procesar el formulario y guardar el ejercicio
Route::post('/exercises', [ExerciseController::class, 'store'])->name('exercise.store');


Route::get('/myworkouts', function () {
    return view('myworkouts');
})->middleware(['auth', 'verified'])->name('myworkouts');

Route::middleware('auth')->group(function () {
// Ruta para ver el formulario de edición del perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
// Ruta para actualizar los datos del perfil
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
// Ruta para eliminar la foto de perfil
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/**Route::middleware('auth')->group(function () {
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');
});
 */
require __DIR__.'/auth.php';
