<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN / REGISTER)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| ADMIN API
|--------------------------------------------------------------------------
*/

Route::middleware('admin.api')->prefix('admin')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Api\Admin\AdminAuthController::class, 'dashboard']);

    // Manajemen User
    Route::get('/users', [\App\Http\Controllers\Api\Admin\ManageUserController::class, 'index']);
    Route::delete('/users/{id}', [\App\Http\Controllers\Api\Admin\ManageUserController::class, 'destroy']);
    Route::post('/users/{role}/{id}/toggle', [\App\Http\Controllers\Api\Admin\ManageUserController::class, 'toggleActive']);

    // Verifikasi Event
    Route::get('/events/pending', [\App\Http\Controllers\Api\Admin\EventController::class, 'pending']);
    Route::post('/events/{id}/verify', [\App\Http\Controllers\Api\Admin\EventController::class, 'verify']);
    Route::post('/events/{id}/reject', [\App\Http\Controllers\Api\Admin\EventController::class, 'reject']);

    // Transaksi
    Route::get('/transactions', [\App\Http\Controllers\Api\Admin\AdminTransaksiController::class, 'index']);
    Route::put('/transactions/{id}', [\App\Http\Controllers\Api\Admin\AdminTransaksiController::class, 'updateStatus']);
    Route::delete('/transactions/{id}', [\App\Http\Controllers\Api\Admin\AdminTransaksiController::class, 'destroy']);

    // FAQ
    Route::get('/faqs', [\App\Http\Controllers\Api\Admin\FaqController::class, 'index']);
    Route::post('/faqs', [\App\Http\Controllers\Api\Admin\FaqController::class, 'store']);
    Route::put('/faqs/{id}', [\App\Http\Controllers\Api\Admin\FaqController::class, 'update']);
    Route::delete('/faqs/{id}', [\App\Http\Controllers\Api\Admin\FaqController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| PENYELENGGARA API
|--------------------------------------------------------------------------
*/

Route::middleware('penyelenggara.api')->prefix('penyelenggara')->group(function () {

    Route::get('/events', [\App\Http\Controllers\Api\Penyelenggara\EventController::class, 'index']);
    Route::post('/events', [\App\Http\Controllers\Api\Penyelenggara\EventController::class, 'store']);
    Route::get('/events/{id}', [\App\Http\Controllers\Api\Penyelenggara\EventController::class, 'show']);
    Route::put('/events/{id}', [\App\Http\Controllers\Api\Penyelenggara\EventController::class, 'update']);
    Route::delete('/events/{id}', [\App\Http\Controllers\Api\Penyelenggara\EventController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| PENGUNJUNG API
|--------------------------------------------------------------------------
*/

Route::middleware('pengunjung.api')->prefix('pengunjung')->group(function () {

    // Dashboard event
    Route::get('/events', [\App\Http\Controllers\Api\Pengunjung\EventController::class, 'index']);
    Route::get('/events/{id}', [\App\Http\Controllers\Api\Pengunjung\EventController::class, 'show']);

    // Wishlist
    Route::get('/wishlist', [\App\Http\Controllers\Api\Pengunjung\WishlistController::class, 'index']);
    Route::post('/wishlist/{eventId}', [\App\Http\Controllers\Api\Pengunjung\WishlistController::class, 'store']);
    Route::delete('/wishlist/{id}', [\App\Http\Controllers\Api\Pengunjung\WishlistController::class, 'destroy']);

    // Tiket
    Route::get('/tickets/history', [\App\Http\Controllers\Api\Pengunjung\EventController::class, 'history']);
});

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
