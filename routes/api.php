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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('auth/register', App\Http\Controllers\Auth\RegisterController::class);
//add login route


Route::middleware('auth:sanctum')->group(function () {
    // No owner/user grouping, for now, will do it later with more routes
    Route::prefix('owner')->group(function () {
        Route::get('properties',
            [\App\Http\Controllers\Owner\PropertyController::class, 'index']);
        Route::post('properties',
            [\App\Http\Controllers\Owner\PropertyController::class, 'store']);
    });
    
    //Routes for user
    Route::prefix('user')->group(function () {
        Route::get('bookings',
            [\App\Http\Controllers\User\BookingController::class, 'index']);
    });
});
//Public routes
Route::get('search', \App\Http\Controllers\Public\PropertySearchController::class);