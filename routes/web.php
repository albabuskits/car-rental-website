<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes (Livewire)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::view('/', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/cars', 'admin.cars')->name('admin.cars');
    Route::view('/bookings', 'admin.bookings')->name('admin.bookings');
    Route::view('/control-center', 'admin.control-center')->name('admin.control-center');
    Route::view('/users', 'admin.users')->name('admin.users');
    Route::view('/settings', 'admin.settings')->name('admin.settings');
    Route::view('/messages', 'admin.messages')->name('admin.messages');
    Route::view('/licenses', 'admin.licenses')->name('admin.licenses');
});

/*
|--------------------------------------------------------------------------
| Breeze Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('user.dashboard');
    Route::view('/bookings', 'user.dashboard')->name('user.bookings');
    Route::view('/messages', 'user.dashboard')->name('user.messages');
    Route::view('/profile', 'user.dashboard')->name('user.profile');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Vue SPA Catch-All (Public Site)
|--------------------------------------------------------------------------
| All other routes serve the Vue SPA
*/
Route::get('/{any?}', function () {
    return view('spa');
})->where('any', '^(?!api|admin|dashboard|profile|login|register|forgot-password|reset-password|verify-email|email|logout|storage|user).*$');
