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

//comment
Route::post('comments/create','Api\CommentController@create')->middleware('JWTAuth');
Route::post('comments/delete','Api\CommentController@delete')->middleware('JWTAuth');
Route::post('comments/update','Api\CommentController@update')->middleware('JWTAuth');
Route::get('posts/comments','Api\CommentController@comments')->middleware('JWTAuth');


//like
Route::get('posts/likes','Api\LikeController@like')->middleware('JWTAuth');