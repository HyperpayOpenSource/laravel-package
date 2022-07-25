<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
Route::get("/hyperpay/payment", [PaymentController::class ,'payment'])->middleware('web');
