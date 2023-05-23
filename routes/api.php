<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public;
use App\Http\Controllers\Owner\PropertyPhotoController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\Public\PropertySearchController;
use App\Http\Controllers\Public\PropertyController as PublicPropertyController;



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
        //...
    
        Route::post('properties/{property}/photos', [PropertyPhotoController::class, 'store']);
        Route::post('properties/{property}/photos/{photo}/reorder/{newPosition}', [PropertyPhotoController::class, 'reorder']);
    });

    //Routes for user
    Route::prefix('user')->group(function () {
        Route::resource('bookings', BookingController::class);
    });
});

//Public routes
Route::get('search', PropertySearchController::class);
//Get properties by id
Route::get('properties/{property}', Public\PropertyController::class);
//Get apartments by id
Route::get('apartments/{apartment}', Public\ApartmentController::class);
