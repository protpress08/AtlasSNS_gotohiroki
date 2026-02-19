<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('top', [PostsController::class, 'index']);
    Route::get('/home', [PostsController::class, 'index']);
    Route::post('/post/create', [PostsController::class, 'postCreate'])->name('post.create');
    Route::post('/post/update', [PostsController::class, 'postUpdate'])->name('post.update');
    Route::get('/post/{id}/delete', [PostsController::class, 'postDelete'])->name('post.delete');

    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('profile/{id}', [ProfileController::class, 'otherProfile'])->name('profile.other');

    Route::get('search', [UsersController::class, 'search'])->name('user.search');

    Route::get('/user/{id}/follow', [UsersController::class, 'follow'])->name('follow');
    Route::get('/user/{id}/unfollow', [UsersController::class, 'unfollow'])->name('unfollow');

    Route::get('follow-list', [FollowsController::class, 'followList'])->name('follow.list');
    Route::get('follower-list', [FollowsController::class, 'followerList'])->name('follower.list');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});


Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // 登録画面
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    // 登録処理
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');

    // 登録完了画面
    Route::get('/register/added', function () {
        return view('auth.added');
    })->name('register.added');

});

