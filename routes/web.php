<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\HotelImageController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\User\BookmarkController;
use App\Http\Controllers\User\UserTicketController;
use App\Http\Controllers\User\OrderHistoryController;
use App\Http\Controllers\ReviewController;

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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | HOTEL USER
    */
    Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');

    /*
    | BOOKING
    */
    Route::get('/booking/form/{room}', [BookingController::class, 'form'])->name('booking.form');
    Route::post('/booking/create-payment', [BookingController::class, 'createPayment'])->name('booking.createPayment');
    Route::post('/midtrans/notification', [BookingController::class, 'handleNotification'])->name('midtrans.notification');
    Route::get('/booking/success', [BookingController::class, 'paymentSuccess'])->name('booking.success');

    /*
    | BOOKMARK HOTEL
    */
    Route::get('/saved', [BookmarkController::class, 'index'])->name('bookmark.index');
    Route::get('/saved-hotels', [BookmarkController::class, 'index'])->name('saved.hotels');
    Route::post('/hotels/{hotel}/bookmark', [BookmarkController::class, 'store'])->name('bookmark.store');
    Route::delete('/hotels/{hotel}/bookmark', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');

    /*
    | RIWAYAT PESANAN (FIXED)
    */
    Route::get('/riwayat-pesanan', [OrderHistoryController::class, 'index'])
        ->name('user.order-history');

    /*
    | 🎫 TIKET USER
    */
    Route::get('/tickets', [UserTicketController::class, 'index'])
        ->name('tickets.index');

    Route::get('/tickets/{ticket}', [UserTicketController::class, 'show'])
        ->name('tickets.show');


Route::get('/reviews/{order}/create', [ReviewController::class, 'create'])
    ->name('reviews.create');

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

        Route::get('hotels/{hotel}', [AdminHotelController::class, 'show'])
            ->name('admin.hotels.show');

        Route::delete('hotels/images/{image}', [HotelImageController::class, 'destroy'])
            ->name('admin.hotels.images.destroy');

        Route::get('/bookings', [\App\Http\Controllers\Admin\AdminBookingController::class, 'index'])
            ->name('admin.bookings.index');

        Route::get('/bookings/{booking}', [\App\Http\Controllers\Admin\AdminBookingController::class, 'show'])
            ->name('admin.bookings.show');

        Route::post('/bookings/{booking}/approve', [\App\Http\Controllers\Admin\AdminBookingController::class, 'approve'])
            ->name('admin.bookings.approve');

        Route::post('/bookings/{booking}/reject', [\App\Http\Controllers\Admin\AdminBookingController::class, 'reject'])
            ->name('admin.bookings.reject');

        Route::post('/bookings/{booking}/refund', [\App\Http\Controllers\Admin\AdminBookingController::class, 'refund'])
            ->name('admin.bookings.refund');
    });

/*
|--------------------------------------------------------------------------
| Promo Kamar
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_operasional'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');
        Route::get('/promo/create', [PromoController::class, 'create'])->name('promo.create');
        Route::post('/promo', [PromoController::class, 'store'])->name('promo.store');
        Route::get('/promo/{promo}/edit', [PromoController::class, 'edit'])->name('promo.edit');
        Route::put('/promo/{promo}', [PromoController::class, 'update'])->name('promo.update');
        Route::delete('/promo/{promo}', [PromoController::class, 'destroy'])->name('promo.destroy');
    });

/*
|--------------------------------------------------------------------------
| Hotel Search
|--------------------------------------------------------------------------
*/
Route::get('/hotels', function () {
    return view('penginapan.index');
})->name('hotels.index');

Route::get('/hotels-nearby', [HotelController::class, 'nearby']);

require __DIR__ . '/auth.php';
