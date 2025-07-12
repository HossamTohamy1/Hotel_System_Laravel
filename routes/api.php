<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/test', function () {
    return [
        'message' => 'Test route is working',
        'status' => 'success'
        ];
});

Route::post('/user', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');

Route::post('/room', [App\Http\Controllers\RoomController::class, 'store'])->name('room.store');
Route::get('/room', [App\Http\Controllers\RoomController::class, 'index'])->name('room.index');
Route::get('/room/{id}', [App\Http\Controllers\RoomController::class, 'show'])->name('room.show');
Route::put('/room/{id}', [App\Http\Controllers\RoomController::class, 'update'])->name('room.update');



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/offers', [App\Http\Controllers\OfferController::class, 'store'])->name('offers.store');


