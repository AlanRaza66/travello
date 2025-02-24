<?php

use App\Http\Controllers\MessageController;
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
    Route::prefix('/messages')->controller(MessageController::class)->name("messages.")->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/m/{user:slug}', 'show')->name('show');
    });

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
    Route::delete('/p/{post:id}', [PostController::class, "delete"])->name('post.delete');
    Route::post('/p/{post:id}', [PostController::class, "comment"])->name('post.comment');
    Route::delete('/comment/{comment:id}', [PostController::class, "deleteComment"])->name('post.uncomment');
    Route::post('/comment/{comment:id}/like', [PostController::class, "likeComment"])->name('post.comment.like');
});





require __DIR__ . '/auth.php';
