<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\RoomController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home'); // halaman landing
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Operasional Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_operasional'])
    ->prefix('admin-operasional')
    ->group(function () {

    // CRUD Hotel
    Route::resource('hotels', HotelController::class);

    // CRUD Kamar (nested rooms per hotel)
    Route::resource('hotels.rooms', RoomController::class);
});

require __DIR__.'/auth.php';
