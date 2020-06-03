<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//user
Route::post('login','Api\AuthController@login');
Route::post('register','Api\AuthController@register');
Route::get('logout','Api\AuthController@logout');


//post
Route::post('posts/create','Api\PostController@create')->middleware('JWTAuth');
Route::post('posts/delete','Api\PostController@delete')->middleware('JWTAuth');
Route::post('posts/update','Api\PostController@update')->middleware('JWTAuth');
Route::get('posts','Api\PostController@posts')->middleware('JWTAuth');