<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MovieController;
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

// Route::group(["namespace" => "app/Http/Controllers/Auth"], function () {
//     Route::post("fistStepLogin", "LoginController@ping");
// });

Route::post('checkEmail', [LoginController::class, 'checkEmail']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    Route::resource('movies', MovieController::class);
    // Route::resource("users", UserController::class);
});

// Route::resource("users", UserController::class);

Route::get('ping', function (Request $request) {
    return 'pong';
});
