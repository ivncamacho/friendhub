<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**Route::get('/', function () {
    return view('welcome');
});*/
Route::view('/', 'index')->name('index');

Route::get('/feed', function () {
    return view('feed.mainPage');
})->middleware(['auth', 'verified'])->name('feed');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/myworkouts', function () {
    return view('myworkouts');
})->middleware(['auth', 'verified'])->name('myworkouts');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
