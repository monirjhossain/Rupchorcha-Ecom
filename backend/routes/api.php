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

// Payment Gateway APIs
Route::get('/payment/gateways', [\App\Http\Controllers\PaymentController::class, 'gateways']);
Route::post('/payment/initiate', [\App\Http\Controllers\PaymentController::class, 'initiate'])->middleware('auth:sanctum');
Route::post('/payment/callback/{gateway}', [\App\Http\Controllers\PaymentController::class, 'callback']);
