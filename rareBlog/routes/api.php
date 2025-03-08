<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VoteController;
// use app\Http\Controllers\RegisterController;

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



Route::group([

    'middleware' => 'api',
    'prefix' => 'app'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);


    //blog routes
    Route::post('blog/create', [BlogController::class, 'create']);
    Route::post('blog/edit', [BlogController::class,'edit']);
    Route::post('blog/delete', [BlogController::class,'delete']);

    //comment routes
    Route::post('comment/create', [CommentController::class, 'create']);
    Route::post('comment/edit', [CommentController::class,'edit']);

    //vote routes
    Route::post('vote/create', [VoteController::class, 'create']);



});



Route::group([

    'prefix' => 'app'

], function ($router) {


    Route::post('register', [app\Http\Controllers\RegisterController::class, 'register']);

    Route::get('blogs/all', [BlogController::class, 'getAllBlogs']);
    Route::get('blogs/single/{id}', [BlogController::class,'singleBlog']);
});