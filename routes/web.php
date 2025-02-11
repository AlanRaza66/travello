<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('/profile')->controller(ProfileController::class)->name("profile.")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::patch('/upload', 'upload')->name('picture.upload');
        Route::patch('/delete', 'deletePicture')->name('picture.delete');
        Route::delete('/', 'destroy')->name('destroy');
        Route::get('/{user:slug}', [ProfileController::class, 'getUser'])->name('user');
        Route::put('/follow/{user:slug}', [ProfileController::class, 'follow'])->name('follow');
        Route::put('/unfollow/{user:slug}', [ProfileController::class, 'unfollow'])->name('unfollow');
    });
});





require __DIR__ . '/auth.php';
