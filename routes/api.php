<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // Protected routes that require authentication

    // Route for retrieving authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    // Post endpoints
    Route::apiResource('posts', 'App\Http\Controllers\PostController');

    // Comment endpoints
    Route::apiResource('comments', 'App\Http\Controllers\CommentController');

    // Category endpoints
    Route::apiResource('categories', 'App\Http\Controllers\CategoryController');

});



// Route for logging in second option if the user doesn't have a API token
Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');