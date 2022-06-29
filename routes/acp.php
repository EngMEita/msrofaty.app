<?php
use Illuminate\Support\Facades\Route;

Route::prefix('acp')->name('acp.')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('acp.dashboard');
    })->name('dashboard');

    Route::resource('user', App\Http\Controllers\Acp\UserController::class);

    Route::resource('account', App\Http\Controllers\Acp\AccountController::class);

    Route::resource('category', App\Http\Controllers\Acp\CategoryController::class);

    Route::resource('entry', App\Http\Controllers\Acp\EntryController::class);

    Route::resource('record', App\Http\Controllers\Acp\RecordController::class);

    Route::resource('budget', App\Http\Controllers\Acp\BudgetController::class);
});
