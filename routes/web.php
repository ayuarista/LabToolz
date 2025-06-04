<?php

use App\Livewire\Item;
use App\Livewire\ItemShow;
use App\Livewire\LoanForm;
use App\Livewire\LoanShow;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest'])
    ->name('register');


    Route::middleware(['auth'])->group(function () {
        Route::get('/items', ItemShow::class)->name('items.show');
        Route::get('/items/create', Item::class)->name('items.create');
        Route::get('/items/edit/{slug}', Item::class)->name('items.edit');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/loans/form', LoanForm::class)->name('loans.form');

        Route::get('/loans', LoanShow::class)->name('loans.show');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
