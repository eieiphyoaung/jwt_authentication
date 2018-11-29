<?php

use Illuminate\Http\Request;

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

Route::post('register','Api\UserController@register');
Route::post('login','Api\UserController@authenticate');
Route::post('logout', 'Api\UserController@logout');
Route::get('open','Api\DataController@open');

Route::group(['middleware'=>'jwt.verify'],function (){
    Route::get('user','Api\UserController@getAuthenticatedUser');
    Route::get('close','Api\DataController@closed');
    Route::get('/articles', 'Api\ArticleController@index');
    Route::get('/articles/{id}', 'Api\ArticleController@show');
    Route::post('/articles', 'Api\ArticleController@store');
    Route::put('/articles/{id}', 'Api\ArticleController@update');
    Route::delete('/articles/{id}', 'Api\ArticleController@delete');
});
