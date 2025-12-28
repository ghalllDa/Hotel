<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelController; // USER
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\RoomController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
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

    // USER HOTEL (SEARCH & DETAIL)
    //Route::get('/hotels/search', [HotelController::class, 'search'])
        //->name('hotels.search');

    //Route::get('/hotels/{hotel}', [HotelController::class, 'show'])
        //->name('hotels.show');
});

/*
|--------------------------------------------------------------------------
| Admin Operasional Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_operasional'])
    ->prefix('admin-operasional')
    ->group(function () {

        Route::resource('hotels', AdminHotelController::class);
        Route::resource('hotels.rooms', RoomController::class);
    });

Route::get('/hotels-nearby', [HotelController::class, 'nearby']);
require __DIR__ . '/auth.php';
