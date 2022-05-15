<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VideoController;
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



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//RUTAS CREADAS PARA REGISTRO Y LOGIN
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [UserController::class, 'authenticate']);
    //Route::post('logout', [UserController::class, 'logout']);
    //Route::post('refresh', [UserController::class, 'refresh']);
    Route::post('me', [UserController::class, 'getAuthenticatedUser']);
    Route::post('register', [UserController::class, 'register']);
});

 //	RUTAS QUE REQUIEREN AUTENTICACIÓN Y OBTENIDA DE DATOS
Route::group([
    'middleware' => 'api',
    'prefix' => 'app'
], function ($router) {
    Route::post('getPosts', [PostController::class, 'getPosts']);
    Route::post('createPost', [PostController::class, 'createPost']);

    Route::post('getVideos', [VideoController::class, 'getVideos']);
    Route::post('createVideo', [VideoController::class, 'createVideo']);

    Route::post('getTags', [TagController::class, 'getTags']);
    Route::post('createTag', [TagController::class, 'createTag']);
   
});


