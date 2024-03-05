<?php

use Illuminate\Support\Facades\Route;

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

Route::redirect('/articles', 'api/articles', 302);

Route::get('/user/{id}', function (string $id) {
    return 'user id: '.$id;
});
Route::get('/name/{name}', function (string $name) {
    return $name;
})->whereAlpha('name');

Route::get('/failure', function () {
    return 'fail to add article';
});

Route::get('/failure/update', function () {
    return 'fail to update article';
});
