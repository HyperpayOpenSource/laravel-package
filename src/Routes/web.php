<?php

use Illuminate\Support\Facades\Route;
use Hyperpay\Payment\Controllers\MainController;
Route::get("/hyperpay/payment", [MainController::class ,'payment']);
Route::get("/hyperpay/form/{id}", [MainController::class ,'form']);
Route::get("/test", [MainController::class ,'test']);

// Route::group(function(){
//     // Route::get(config('connect-in.end_points')['payment'], [class_exists('App\Http\Controllers\ConnectInController') ? 'App\Http\Controllers\ConnectInController' : ConnectInController::class , 'payment']);
// });
