<?php

use App\Http\Controllers\Api\v1\QuoteController;
use App\Http\Controllers\Api\v1\UsersController;
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

require __DIR__ . '/auth.php';

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('users', UsersController::class);
    Route::post('users/{user}/password', [UsersController::class, 'changePassword']);

    Route::post('quotes', [QuoteController::class, 'store']);
});
