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

Route::apiResource('users', App\Http\Controllers\API\V1\UserController::class);

Route::post('account', 'App\Http\Controllers\API\V1\AccountController@store')
    ->middleware('check.data.to.account');

Route::middleware(['check.data.to.transaction'])->group(function () {

    Route::post('deposit', 'App\Http\Controllers\API\V1\TransactionController@deposit');

    Route::post('withdraw', 'App\Http\Controllers\API\V1\TransactionController@withdraw')
        ->middleware('check.insufficient.funds.to.transaction');
});

Route::post('extract', 'App\Http\Controllers\API\V1\TransactionController@extract')
    ->middleware('check.data.to.extract');
