<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/person_view',[ApiController::class,'index']);
Route::get('/invoice_view',[ApiController::class,'invoice_view']);
Route::get('/receipt_view',[ApiController::class,'receipt_view']);
Route::get('/client_Summary',[ApiController::class,'client_Summary']);

