<?php

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

//Route::get('/', function () {
//    $people=['Matt','John','Mary','Smith'];
//    return view('welcome',compact('people'));
//});

//Route::get('about',function(){
//    return view('pages.about');
//});

Route::get('/','PagesController@home');
Route::get('about','PagesController@about');
