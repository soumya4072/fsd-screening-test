<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\AnalyticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider
| and assigned the "api" middleware group.
| URL prefix: /api
|--------------------------------------------------------------------------
*/

Route::get('/health', function () {
    return response()->json([
        'status' => 'API is working'
    ]);
});

/*
|--------------------------------------------------------------------------
| API V1 Routes (Protected)
|--------------------------------------------------------------------------
*/

//Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // Booking CRUD API
    //Route::apiResource('bookings', BookingController::class);

   // Route::get('analytics/bookings', [AnalyticsController::class, 'bookings']);

//});

Route::prefix('v1')->group(function () {
    Route::apiResource('bookings', BookingController::class);
    Route::get('analytics/bookings', [AnalyticsController::class, 'bookings']);
});

