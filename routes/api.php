<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('userAuth')->resource('articles', ArticleController::class, ['only' => ['index','store', 'show', 'update', 'destroy']]);
Route::middleware('userAuth')->get('/user/{id}', [UserController::class, 'show']);

Route::group(['prefix' => 'auth'], function() {
    Route::get('/register', fn() => 'register')->name('register');
    Route::get('/login', array(fn() => 'login', 'as' => 'login'));
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::controller(TagController::class)
    ->middleware('userAuth')
    ->prefix('tags')
    ->group(function() {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
});
