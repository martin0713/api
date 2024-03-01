<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Article;
use App\Models\User;

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

Route::get('/articles', function () {
    return Article::all();
});

Route::get('/articles/{id}', function (string $id) {
    $article = Article::find($id);
    $user = $article->user;
    return $article;
});

Route::get('/user/{id}', function ($id) {
    $user = User::find($id);
    $articles = $user->articles;
    return $articles;
});

// todo change http method to POST
Route::get('/articles/{id}/edit', function (Article $article, string $id) {
    $target = $article::find($id);
    $target->body = uniqid();
    $record = $target->records;
    $record['time']++;
    $target->records = $record;
    $target->save();
    return $target;
});
// todo change http method to POST
Route::get('/articles/edit', function (Article $article) {
    $all = Article::all();
    $all->each->update([
        'body' => uniqid(),
    ]);
    return $all;
});
// todo change http method to POST
Route::get('/articles/add', function (Article $article) {
    $new = new $article;
    $new->title = 'test'.rand();
    $new->body = uniqid();
    $record = [
        'time' => 1
    ];
    $new->records = json_encode($record);
    $new->author_id = rand(1,3);
    $new->image = uniqid();
    $new->save();
    return $new;
});
// todo change http method to delete
Route::get('/articles/{id}/delete', function (Article $article, string $id) {
    $target = $article::find($id);
    if ($target) {
        $target->delete();
        return 'the post </br>'.$target.'</br>is deleted successfully';
    } else {
        return 'the post '.$id.' has been deleted already';
    }
});
// todo change http method to delete
Route::get('/articles/delete', function (Article $article) {
    $all = Article::all();
    $all->each->delete();
    return $all;
});