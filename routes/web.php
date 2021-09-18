<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::post('/posts/{post}/reacts/{user}',[App\Http\Controllers\ReactController::class, 'store']);
Route::post('/follow/{user}', [App\Http\Controllers\FollowController::class, 'store']);

Route::get('/', [App\Http\Controllers\PostsController::class, 'index']);
Route::post('/p', [App\Http\Controllers\PostsController::class, 'store']);
Route::post('/newsFeed', [App\Http\Controllers\PostsController::class, 'news']);
Route::get('/p/create', [App\Http\Controllers\PostsController::class, 'create']);
Route::get('/p/{post}', [App\Http\Controllers\PostsController::class, 'show']);
Route::get('/post/{post}', [App\Http\Controllers\PostsController::class, 'showPost']);
Route::get('/destroy/{post}', [App\Http\Controllers\PostsController::class, 'destroy']);
Route::get('/edit/{post}', [App\Http\Controllers\PostsController::class, 'edit']);
Route::patch('/editPost/{post}', [App\Http\Controllers\PostsController::class, 'update']);


Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.index');
Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update');
Route::post('/posts/{post}/comments', [App\Http\Controllers\PostsController::class, 'addComment'])->name('profile.comment');
Route::post('/posts/{post}/comment', [App\Http\Controllers\PostsController::class, 'addShowComment'])->name('profile.showComment');



Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

require __DIR__.'/auth.php';