<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('items', ItemController::class);
Route::resource('loans', LoanController::class);