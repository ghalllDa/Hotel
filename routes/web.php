<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelController; // USER
use App\Http\Controllers\BookingController; // BOOKING
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\HotelImageController;
use App\Http\Controllers\Admin\PromoController;

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

    // routes/web.php (di dalam middleware auth)
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.photo.update');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // DETAIL HOTEL (USER)
    Route::get('/hotels/{id}', [HotelController::class, 'show'])
        ->name('hotels.show');

    // BOOKING KAMAR
    Route::get('/booking/form/{room}', [BookingController::class, 'form'])->name('booking.form');
    Route::post('/booking/create-payment', [BookingController::class, 'createPayment'])->name('booking.createPayment');
    Route::post('/midtrans/notification', [BookingController::class, 'handleNotification'])->name('midtrans.notification');
    Route::get('/booking/success', [BookingController::class, 'paymentSuccess'])->name('booking.success');
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
        Route::get('hotels/{hotel}', [AdminHotelController::class, 'show'])
            ->name('admin.hotels.show');

        // HAPUS FOTO HOTEL
        Route::delete('hotels/images/{image}', [HotelImageController::class, 'destroy'])
            ->name('admin.hotels.images.destroy');
    });

/*
|--------------------------------------------------------------------------
| Promo Kamar (ADMIN OPERASIONAL)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_operasional'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/promo', [PromoController::class, 'index'])
            ->name('promo.index');

        Route::get('/promo/create', [PromoController::class, 'create'])
            ->name('promo.create');

        Route::post('/promo', [PromoController::class, 'store'])
            ->name('promo.store');
    });

/*
|--------------------------------------------------------------------------
| Hotel Terdekat / Search
|--------------------------------------------------------------------------
*/
Route::get('/hotels', function() {
    return view('penginapan.index');
})->name('hotels.index');

Route::get('/hotels-nearby', [HotelController::class, 'nearby']);
Route::get('/hotels/{id}', [HotelController::class, 'show']);

require __DIR__ . '/auth.php';