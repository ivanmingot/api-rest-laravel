<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RestController;

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

Route::get('/', function () {
    return view('welcome');
});

/*******
* USER *
*******/
Route::post('/api/register', [UserController::class, 'register']);
Route::post('/api/login', [UserController::class, 'login']);
Route::post('/api/update', [UserController::class, 'update']);

/*******
* POST *
*******/

Route::post('/api/post/', [PostController::class, 'index']);
Route::get('/api/post/{id}', [PostController::class, 'show']);
Route::post('/api/post/store', [PostController::class, 'store']);
Route::post('/api/post/upload', [PostController::class, 'upload']);
Route::get('/api/post/image/{filename}', [PostController::class, 'getImage']);
Route::post('/api/post/dates/', [PostController::class, 'getPostsByDates']);
Route::get('/api/post/myposts/{id}', [PostController::class, 'getMyPosts']);


