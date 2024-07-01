<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;

// Route::middleware('validate.token')->group(function () {
    Route::get('/person_view',[ApiController::class,'index']);
    Route::get('/invoice_view',[ApiController::class,'invoice_view']);
    Route::get('/receipt_view',[ApiController::class,'receipt_view']);
    Route::get('/client_Summary',[ApiController::class,'client_Summary']);
    Route::post('/logout',[AuthController::class,'logout']);
// });

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/email-verify',[AuthController::class,'emailVerify']);
Route::post('/reset-pass',[AuthController::class,'resetPass']);
Route::post('/forgot-pass',[AuthController::class,'forgotPass']);
Route::post('/refresh-token',[AuthController::class,'refreshToken']);
