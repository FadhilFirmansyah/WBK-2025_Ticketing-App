<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [App\Http\Controllers\User\EventController::class, 'show'])->name('events.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('events', App\Http\Controllers\Admin\EventController::class);
        Route::resource('tickets', App\Http\Controllers\Admin\TicketController::class);
        
        Route::get('/histories', [App\Http\Controllers\Admin\HistoryController::class, 'index'])->name('histories.index');
        Route::get('/histories/{id}', [App\Http\Controllers\Admin\HistoryController::class, 'show'])->name('histories.show');
    });
});

require __DIR__.'/auth.php';
