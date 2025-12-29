<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelController; // USER
use App\Http\Controllers\BookingController; // BOOKING
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\HotelImageController;

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

    // DETAIL HOTEL (USER)
    Route::get('/hotels/{id}', [HotelController::class, 'show'])
        ->name('hotels.show');

    // BOOKING KAMAR
    Route::get('/booking/{room}', [BookingController::class, 'create'])
        ->name('booking.create');
});

/*
|--------------------------------------------------------------------------
| Admin Operasional Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_operasional'])
    ->prefix('admin-operasional')
    ->group(function () {

        // HOTEL (CRUD)
        Route::resource('hotels', AdminHotelController::class);

        // ROOM PER HOTEL
        Route::resource('hotels.rooms', RoomController::class);

        // DETAIL HOTEL (ADMIN)
        Route::get(
            'hotels/{hotel}',
            [AdminHotelController::class, 'show']
        )->name('admin.hotels.show');

        // HAPUS FOTO HOTEL
        Route::delete(
            'hotels/images/{image}',
            [HotelImageController::class, 'destroy']
        )->name('admin.hotels.images.destroy');
    });

// HOTEL TERDEKAT
Route::get('/hotels-nearby', [HotelController::class, 'nearby']);

require __DIR__ . '/auth.php';