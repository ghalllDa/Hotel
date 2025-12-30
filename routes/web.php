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
    // Webhook untuk Midtrans notification (wajib CSRF exempt atau gunakan api route)
    Route::post('/midtrans/notification', [BookingController::class, 'handleNotification'])->name('midtrans.notification');
    Route::get('/payment-success', [BookingController::class, 'paymentSuccess'])->name('payment.success');
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

/*
|--------------------------------------------------------------------------
| Promo Kamar (ADMIN OPERASIONAL)  ✅ FIX DI SINI
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


// HOTEL TERDEKAT
Route::get('/hotels-nearby', [HotelController::class, 'nearby']);

require __DIR__ . '/auth.php';
