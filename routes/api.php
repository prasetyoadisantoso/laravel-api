<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\Admin\UserController;
use App\Http\Controllers\API\v1\Admin\BookController;
use App\Http\Controllers\API\v1\Client\HomeController;

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


Route::group(['prefix' => 'v1'], function(){

    // Authentication Process
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

    // Administrator
    Route::group(['prefix' => 'administrator'], function(){
        Route::get('dashboard', [BookController::class, 'index']);
        Route::post('create-book', [BookController::class, 'createBook']);
        Route::post('edit-book', [BookController::class, 'editBook']);
        Route::post('delete-book', [BookController::class, 'deleteBook']);
    });

    // Client
    Route::group(['prefix' => 'client'], function(){
        Route::get('home', [HomeController::class, 'index']);
    });

});
