<?php

use App\Http\Controllers\PostController;
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

    Route::prefix('/{user:slug}/p')->controller(PostController::class)->name('post.')->group(function () {
        Route::get('/', 'index')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{post:id}', 'show')->name('show');
    });

    Route::post("/like/{post:id}", [PostController::class, "like"])->name('post.like');
    Route::post("/unlike/{post:id}", [PostController::class, "unlike"])->name('post.unlike');
    Route::delete('/p/{post:id}', [PostController::class, "delete"])->name('post.delete');
});





require __DIR__ . '/auth.php';
