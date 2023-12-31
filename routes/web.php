<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/locales/{locale}', function ($locale) {
    $locale = str_replace('-', '_', $locale);
    if (isset($locale) && in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return response()->json([
        'locale' => $locale,
        'appLocale' => app()->getLocale(),
        'sessionLocale' => session()->get('locale')
    ]);
})->name('locale');

Route::get('/current-locale', function () {
    return response()->json([
        'locale' => session()->has('locale') ? session()->get('locale') : app()->getLocale(),
        'app_locale' => str_replace('_', '-', app()->getLocale()),
        'fallback_locale' => str_replace('_', '-', config('app.fallback_locale')),
    ]);
})->name('current-locale');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(\App\Http\Controllers\RoomController::class)
        ->prefix('rooms')
        ->group(function () {
            Route::get('/{room}/edit', 'edit')->name('rooms.edit');
            Route::put('/{room}', 'update')->name('rooms.update');
            Route::delete('/{room}', 'destroy')->name('rooms.destroy');
        });

    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('hotels', \App\Http\Controllers\HotelController::class);
    Route::controller(\App\Http\Controllers\RoomController::class)
        ->prefix('rooms')
        ->group(function () {
            Route::get('/{room}/edit', 'edit')->name('rooms.edit');
            Route::put('/{room}', 'update')->name('rooms.update');
            Route::delete('/{room}', 'destroy')->name('rooms.destroy');
        });
});
