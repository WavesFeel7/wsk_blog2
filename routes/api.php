<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use app\Http\Controllers\AuthController;
// use app\Http\Controllers\PostController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    [
        'prefix' => 'auth'
    ],
    function () {
        Route::post('login', 'AuthController@login');
        Route::post('registration', 'AuthController@registration');

        Route::group(['middleware' => 'jwt.auth'], function () {

            Route::post('logout', 'AuthController@logout');
        });
    }
);

Route::group(
    [
        'prefix' => 'post'
    ],
    function () {
        Route::group(['middleware' => 'jwt.auth'], function () {

            Route::get('index', 'PostController@index');
            Route::post('createPost', 'PostController@store');
            Route::put('updatePost/{id}', 'PostController@update');
            Route::delete('deletePost/{id}', 'PostController@destroy');
            Route::post('createComment/{id}', 'CommentController@store');
            Route::post('likes/{id}', 'LikeController@store');
            Route::get('countLikes/{id}', 'LikeController@countLikes');
        });
    }
);
