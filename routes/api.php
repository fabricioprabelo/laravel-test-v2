<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('users', \App\Http\Controllers\UserController::class)->names('api.users');
    Route::resource('roles', \App\Http\Controllers\RoleController::class)->names('api.roles');
    Route::resource('hotels', \App\Http\Controllers\HotelController::class)->names('api.hotels');
    Route::controller(\App\Http\Controllers\RoomController::class)
        ->prefix('rooms')
        ->group(function () {
            Route::get('/{room}/edit', 'edit')->name('api.rooms.edit');
            Route::put('/{room}', 'update')->name('api.rooms.update');
            Route::delete('/{room}', 'destroy')->name('api.rooms.destroy');
        });
});
