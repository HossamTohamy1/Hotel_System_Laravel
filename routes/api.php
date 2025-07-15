<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FeedbackController;


Route::get('/test', function () {
    return [
        'message' => 'Test route is working',
        'status' => 'success'
        ];
});
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);




    Route::post('/room', [RoomController::class, 'store'])->name('room.store');
    Route::get('/room', [RoomController::class, 'index'])->name('room.index');
    Route::get('/room/{id}', [RoomController::class, 'show'])->name('room.show');
    Route::put('/room/{id}', [RoomController::class, 'update'])->name('room.update');



    Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
    route::put('/offers/{id}', [OfferController::class, 'update'])->name('offers.update');
    Route::delete('/offers/{id}', [OfferController::class, 'destroy'])->name('offers.destroy');

    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::post('/update-room-availability', [RoomController::class, 'updateAvailability']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);

    Route::patch('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);
    Route::get('/reservations/room/{room_number}', [ReservationController::class, 'showByRoomNumber']);
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

});
