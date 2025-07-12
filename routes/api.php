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


Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
