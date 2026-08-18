<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Platform\DashboardController;
use App\Http\Controllers\Platform\HouseholdController;
Route::prefix('admin')->name('platform.')->middleware(['auth','platform.admin'])->group(function () {
 Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
 Route::post('/households', [HouseholdController::class, 'store'])->name('households.store');
 Route::patch('/households/{household}/status', [HouseholdController::class, 'updateStatus'])->name('households.status');
});
