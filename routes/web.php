<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminTransaksiController;
use App\Http\Controllers\Penyelenggara\PenyelenggaraAuthController;
use App\Http\Controllers\Pengunjung\PengunjungAuthController;
use App\Http\Controllers\Pengunjung\WishlistController;
use App\Http\Controllers\FaqController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PenyelenggaraMiddleware;
use App\Http\Middleware\PengunjungMiddleware;
use App\Http\Controllers\Admin\AdminEventController;
use App\Models\Admin;
use App\Models\Event;
use App\Models\User;


Route::get('/', function () {
    $events = Event::latest()->get();
    $organizers = [];
    return view('layout.index', compact('events', 'organizers'));
})->name('layout.index');


//admin
Route::middleware('web.admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
});
// Manajemen User
Route::get('/manageuser', [ManageUserController::class, 'index'])->name('admin.user.manageuser');
// Toggle aktif / nonaktif
Route::post('/manageuser/{role}/{id}/toggle', [ManageUserController::class, 'toggleActive'])->name('admin.user.toggle');
// Hapus user
Route::delete('/manageuser/{user}', [ManageUserController::class, 'destroy'])->name('admin.user.destroy');
Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

// Verifikasi Event
Route::get('/events/verifikasi', [EventController::class, 'pending'])->name('admin.events.verifikasi');
Route::post('/events/{id}/verify', [EventController::class, 'verify'])->name('admin.events.verify');
Route::post('/events/{id}/reject', [EventController::class, 'reject'])->name('admin.events.reject');


     //manajemen transaksi
Route::get('/transactions', [AdminTransaksiController::class, 'index'])->name('admin.transactions.index');
Route::put('/transactions/{id}/update', [AdminTransaksiController::class, 'updateStatus'])->name('admin.transactions.update');
Route::delete('/transactions/{id}', [AdminTransaksiController::class, 'destroy'])->name('admin.transactions.destroy');

      //manajemen faq
Route::get('/faqs', [FaqController::class, 'index'])->name('admin.faqs.index');
Route::get('/faqs/create', [FaqController::class, 'create'])->name('admin.faqs.create');
Route::post('/faqs', [FaqController::class, 'store'])->name('admin.faqs.store');
Route::get('/faqs/{id}/edit', [FaqController::class, 'edit'])->name('admin.faqs.edit');
Route::put('/faqs/{id}', [FaqController::class, 'update'])->name('admin.faqs.update');
Route::delete('/faqs/{id}', [FaqController::class, 'destroy'])->name('admin.faqs.destroy');


// --- PENYELENGGARA ---
Route::middleware('penyelenggara.web')->prefix('penyelenggara')->group(function () {
Route::get('/events', [EventController::class, 'index'])->name('penyelenggara.events.dashboard');
Route::get('/events/create', [EventController::class, 'create'])->name('penyelenggara.events.create');
Route::post('/events', [EventController::class, 'store'])->name('penyelenggara.events.store');
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('penyelenggara.events.edit');
Route::put('/events/{event}', [EventController::class, 'update'])->name('penyelenggara.events.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('penyelenggara.events.destroy');
});


// --- PENGUNJUNG ---
Route::middleware('pengunjung.web')->prefix('pengunjung')->group(function () {
    Route::get('/dashboard', [PengunjungAuthController::class, 'index'])->name('dashboard.pengunjung');
Route::get('/events/{event}', [EventController::class, 'show'])->name('pengunjung.events.show');
Route::get('/search', [EventController::class, 'search'])->name('event.search');
Route::get('/wishlist', [WishlistController::class, 'wishlistPage'])->name('wishlist.page');
Route::post('/wishlist/{event}', [WishlistController::class, 'store'])->name('wishlist.store');
Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
Route::get('/buy/{id}', [EventController::class, 'buy'])->name('event.buy'); 
Route::post('/buy/{id}', [EventController::class, 'processPurchase'])->name('event.buy.process');
Route::get('/event/success', [EventController::class, 'success'])->name('success');
Route::get('/ticket/{transactionId}', [EventController::class, 'showTicket'])->name('event.ticket');
Route::get('/tiket/riwayat', [PengunjungAuthController::class, 'history'])->name('pengunjung.tiket.riwayat');
Route::get('/help-center', [FaqController::class, 'indexPublic'])->name('help.center');
});

// --- AUTH ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::post('/login/Admin', [AdminAuthController::class, 'login'])->name('admin.login.process');
Route::post('/login/penyelenggara', [PenyelenggaraAuthController::class, 'login'])->name('penyelenggara.login.process');
Route::post('/login/pengunjung', [PengunjungAuthController::class, 'login'])->name('pengunjung.login.process');
// Register routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/register/process', [AuthController::class, 'register'])->name('register.process');

// --- LOGOUT ---
Route::post('/logout', function () {
    if(Auth::guard('admin')->check()) Auth::guard('admin')->logout();
    elseif(Auth::guard('penyelenggara')->check()) Auth::guard('penyelenggara')->logout();
    elseif(Auth::guard('pengunjung')->check()) Auth::guard('pengunjung')->logout();
    return redirect('/login');
})->name('logout');

// --- PROFILE ---
Route::get('/profile', [UserController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
