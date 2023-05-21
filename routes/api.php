<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public;

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
Route::post('auth/login', App\Http\Controllers\Auth\LoginController::class);


Route::middleware('auth:sanctum')->group(function () {
    // No owner/user grouping, for now, will do it later with more routes
    Route::prefix('owner')->group(function () {
        Route::get(
            'properties',
            [\App\Http\Controllers\Owner\PropertyController::class, 'index']
        );
        Route::post(
            'properties',
            [\App\Http\Controllers\Owner\PropertyController::class, 'store']
        );

        //add property photo route
        Route::post(
            'properties/{property}/photos',
            [\App\Http\Controllers\Owner\PropertyPhotoController::class, 'store']
        );
        //add property photo reorder route
        Route::post(
            'properties/{property}/photos/{photo}/reorder/{newPosition}',
            [\App\Http\Controllers\Owner\PropertyPhotoController::class, 'reorder']
        );
    });

    //Routes for user
    Route::prefix('user')->group(function () {
        Route::resource('bookings', \App\Http\Controllers\User\BookingController::class);
    });
});

//Public routes
Route::get('search', Public\PropertySearchController::class);
//Get properties by id
Route::get('properties/{property}', Public\PropertyController::class);
//Get apartments by id
Route::get('apartments/{apartment}', Public\ApartmentController::class);
