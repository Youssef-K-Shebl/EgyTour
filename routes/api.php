<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReelController;
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

Route::group(['middleware' => 'jwt.verify'],function () {
    //user
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile/{id?}', [AuthController::class, 'userProfile']);

    //reels
    Route::post('/reels', [ReelController::class, 'index']);
    Route::post('/reels/create', [ReelController::class, 'store']);
    Route::post('/reels/dec', [ReelController::class, 'decVideo']);

    //comments
    Route::post('/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    //likes
    Route::post('/likes', [LikeController::class, 'store']);
    Route::delete('/likes/{id}', [LikeController::class, 'destroy']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
    ], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    //Social authentication
    Route::get('/{provider}/redirect', [AuthController::class, 'redirect']);
    Route::get('/{provider}/callback', [AuthController::class, 'callback']);


});


