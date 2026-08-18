<?php
use Illuminate\Support\Facades\Route;

Route::prefix('family')->name('acp.')->middleware(['auth', 'household'])->group(function () {
    Route::get('/', [App\Http\Controllers\Acp\HomeController::class, 'index'])->name('dashboard');
    Route::get('/report/{year}/{month}', [App\Http\Controllers\Acp\HomeController::class, 'report'])->name('report');

    Route::resource('user', App\Http\Controllers\Acp\UserController::class);

    Route::resource('account', App\Http\Controllers\Acp\AccountController::class);

    Route::resource('category', App\Http\Controllers\Acp\CategoryController::class);

    Route::resource('entry', App\Http\Controllers\Acp\EntryController::class);

    Route::resource('record', App\Http\Controllers\Acp\RecordController::class);

    Route::resource('budget', App\Http\Controllers\Acp\BudgetController::class);
    Route::get('/currency', [App\Http\Controllers\Acp\CurrencyController::class, 'index'])->name('currency.index');
    Route::post('/currency', [App\Http\Controllers\Acp\CurrencyController::class, 'store'])->name('currency.store');
    Route::patch('/currency/{currency}', [App\Http\Controllers\Acp\CurrencyController::class, 'update'])->name('currency.update');
    Route::delete('/currency/{currency}', [App\Http\Controllers\Acp\CurrencyController::class, 'destroy'])->name('currency.destroy');
    Route::get('/currency-conversions', [App\Http\Controllers\Acp\CurrencyConversionController::class, 'index'])->name('currency.conversions');
    Route::post('/currency-conversions', [App\Http\Controllers\Acp\CurrencyConversionController::class, 'store'])->name('currency.conversions.store');
});
