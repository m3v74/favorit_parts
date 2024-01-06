<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::post('get-prices', [\App\Http\Controllers\api\GetController::class, 'getPrices']);
Route::post('get-prices-check', [\App\Http\Controllers\api\GetController::class, 'getPricesCheck']);
