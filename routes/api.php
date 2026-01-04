<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\ManageUserController;
use App\Http\Controllers\Api\Admin\EventController as AdminEventController;
use App\Http\Controllers\Api\Penyelenggara\EventController as EventController;
use App\Http\Controllers\Api\Admin\AdminTransaksiController;
use App\Http\Controllers\Api\Pengunjung\PengunjungAuthController;
use App\Http\Controllers\Api\Penyelenggara\PenyelenggaraAuthController;
use App\Http\Controllers\Api\Admin\FaqController;


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
/*
|--------------------------------------------------------------------------
| ADMIN AUTH (LOGIN)
|--------------------------------------------------------------------------
*/
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware(['auth:sanctum'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminAuthController::class, 'dashboard']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);

        // Manage User
        Route::get('/users', [ManageUserController::class, 'index']);
        Route::delete('/users/{id}', [ManageUserController::class, 'destroy']);
        Route::post('/users/{role}/{id}/toggle', [ManageUserController::class, 'toggleActive']);

        // ✅ EVENT VERIFICATION (ADMIN)
        Route::get('/events/pending', [AdminEventController::class, 'pending']);
        Route::post('/events/{id}/verify', [AdminEventController::class, 'verify']);
        Route::post('/events/{id}/reject', [AdminEventController::class, 'reject']);

        // Transaksi
        Route::get('/transactions', [AdminTransaksiController::class, 'index']);
        Route::put('/transactions/{id}', [AdminTransaksiController::class, 'updateStatus']);
        Route::delete('/transactions/{id}', [AdminTransaksiController::class, 'destroy']);

        // FAQ
        Route::get('/faqs', [FaqController::class, 'index']);
        Route::post('/faqs', [FaqController::class, 'store']);
        Route::put('/faqs/{id}', [FaqController::class, 'update']);
        Route::delete('/faqs/{id}', [FaqController::class, 'destroy']);
    });


/*
|--------------------------------------------------------------------------
| PENYELENGGARA API
|--------------------------------------------------------------------------
*/
Route::post('/penyelenggara/login', [PenyelenggaraAuthController::class, 'login']);

Route::middleware(['auth:sanctum'])
    ->prefix('penyelenggara')
    ->group(function () {

        Route::post('/logout', [PenyelenggaraAuthController::class, 'logout']);

        Route::get('/events', [EventController::class, 'index']);
        Route::post('/events', [EventController::class, 'store']);
    });



/*
|--------------------------------------------------------------------------
| PENGUNJUNG API
|--------------------------------------------------------------------------
*/

// ❌ TANPA middleware (PUBLIC)
Route::post('/pengunjung/login', [PengunjungAuthController::class, 'login']);

// ✅ PAKAI TOKEN
Route::middleware('auth:sanctum')
    ->prefix('pengunjung')
    ->group(function () {

        Route::get('/dashboard', [PengunjungAuthController::class, 'dashboard']);
        Route::get('/history', [PengunjungAuthController::class, 'history']);
        Route::post('/logout', [PengunjungAuthController::class, 'logout']);

        // Event
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
