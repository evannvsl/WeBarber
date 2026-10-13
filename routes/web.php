<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BarberController as AdminBarberController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Barber\DashboardController as BarberDashboard;

// ─────────────────────────────────────────────
// Public / Guest routes
// ─────────────────────────────────────────────
Route::get('/',          [HomeController::class, 'index'])->name('home');
Route::get('/services',  [HomeController::class, 'services'])->name('services');
Route::get('/barbers',   [HomeController::class, 'barbers'])->name('barbers');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─────────────────────────────────────────────
// Customer routes
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/booking',       [CustomerBookingController::class, 'create'])->name('booking');
    Route::post('/booking',      [CustomerBookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/{booking}/cancel', [CustomerBookingController::class, 'cancel'])->name('booking.cancel');
    Route::get('/history',       [CustomerBookingController::class, 'history'])->name('history');
    Route::get('/profile',       [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile',       [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
});

// ─────────────────────────────────────────────
// Admin routes
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',          [AdminDashboard::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users',              [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create',       [UserController::class, 'create'])->name('users.create');
    Route::post('/users',             [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit',  [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}',       [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',    [UserController::class, 'destroy'])->name('users.destroy');

    // Barbers
    Route::get('/barbers',             [AdminBarberController::class, 'index'])->name('barbers.index');
    Route::get('/barbers/create',      [AdminBarberController::class, 'create'])->name('barbers.create');
    Route::post('/barbers',            [AdminBarberController::class, 'store'])->name('barbers.store');
    Route::get('/barbers/{barber}/edit', [AdminBarberController::class, 'edit'])->name('barbers.edit');
    Route::put('/barbers/{barber}',    [AdminBarberController::class, 'update'])->name('barbers.update');
    Route::delete('/barbers/{barber}', [AdminBarberController::class, 'destroy'])->name('barbers.destroy');

    // Services
    Route::get('/services',              [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create',       [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services',             [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}',    [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Schedules
    Route::get('/schedules',                    [ScheduleController::class, 'index'])->name('schedules.index');
    Route::post('/schedules',                   [ScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('/schedules/{schedule}',      [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    // Bookings
    Route::get('/bookings',                       [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}',             [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{booking}/status',      [AdminBookingController::class, 'updateStatus'])->name('bookings.status');

    // Payments
    Route::get('/payments',              [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments',             [PaymentController::class, 'store'])->name('payments.store');
    Route::put('/payments/{payment}',    [PaymentController::class, 'update'])->name('payments.update');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

// ─────────────────────────────────────────────
// Barber routes
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:barber'])->prefix('barber')->name('barber.')->group(function () {
    Route::get('/',          [BarberDashboard::class, 'index'])->name('dashboard');
    Route::get('/bookings',  [BarberDashboard::class, 'bookings'])->name('bookings');
    Route::get('/schedule',  [BarberDashboard::class, 'schedule'])->name('schedule');
    Route::get('/history',   [BarberDashboard::class, 'history'])->name('history');
});
