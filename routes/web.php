<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelController; // USER
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

    Route::get('/hotels/{id}', [HotelController::class, 'show'])
        ->name('hotels.show');

    // Route::get('/hotels/{hotel}', [HotelController::class, 'show'])
    //     ->name('hotels.show');
});

/*
|--------------------------------------------------------------------------
| Admin Operasional Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_operasional'])
    ->prefix('admin-operasional')
    ->group(function () {

        // HOTEL (CRUD + SHOW)
        Route::resource('hotels', AdminHotelController::class);

        // ROOM PER HOTEL
        Route::resource('hotels.rooms', RoomController::class);

        /*
        |--------------------------------------------------------------------------
        | 🔹 TAMBAHAN (WAJIB) — DETAIL HOTEL (KLIK CARD)
        |--------------------------------------------------------------------------
        */
        Route::get(
            'hotels/{hotel}',
            [AdminHotelController::class, 'show']
        )->name('admin.hotels.show');

        Route::delete(
            'hotels/images/{image}',
            [HotelImageController::class, 'destroy']
        )->name('admin.hotels.images.destroy');
    });

Route::get('/hotels-nearby', [HotelController::class, 'nearby']);

require __DIR__ . '/auth.php';
