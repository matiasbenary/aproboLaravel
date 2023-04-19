<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterClientController;
use App\Http\Controllers\Config\ProjectController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SupplierController;
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
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout']);
Route::post('refresh', [LoginController::class, 'refresh']);
Route::post('me', [LoginController::class, 'me']);

Route::post('registerClient', [RegisterClientController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::apiResources(ProjectController::class);
});

// Route::resource("users", UserController::class);

Route::get('ping', function (Request $request) {
    return 'pong';
});

Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/{project}', [ProjectController::class, 'show']);
Route::post('projects', [ProjectController::class, 'store']);
Route::put('projects/{project}', [ProjectController::class, 'update']);

Route::get('suppliers', [SupplierController::class, 'index']);
Route::post('suppliers', [SupplierController::class, 'store']);
Route::post('suppliers/sendInvitation', [SupplierController::class, 'sendInvitation']);

Route::get('invoices/consumer', [InvoiceController::class, 'consumer']);
Route::post('invoices', [InvoiceController::class, 'store']);
