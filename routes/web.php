<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ImportPaymentController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', [
    AuthController::class,
    'login'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'authenticate'
]);

Route::post('/logout', [
    AuthController::class,
    'logout'
]);

/*
|--------------------------------------------------------------------------
| AUTH AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PAYMENT WARGA
    |--------------------------------------------------------------------------
    */

    Route::get('/payment', [
        PaymentController::class,
        'create'
    ]);

    Route::post('/payment', [
        PaymentController::class,
        'store'
    ]);

    /*
    |--------------------------------------------------------------------------
    | HISTORY PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::get('/payment-history', [
        PaymentController::class,
        'history'
    ]);

    /*
    |--------------------------------------------------------------------------
    | CHANGE PASSWORD
    |--------------------------------------------------------------------------
    */

    Route::get('/change-password', [
        PasswordController::class,
        'edit'
    ]);

    Route::post('/change-password', [
        PasswordController::class,
        'update'
    ]);

});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'admin'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | IMPORT DATA LEGACY
    |--------------------------------------------------------------------------
    */

    Route::get('/import-payment', [
        ImportPaymentController::class,
        'index'
    ]);

    Route::post('/import-payment', [
        ImportPaymentController::class,
        'store'
    ]);

    /*
    |--------------------------------------------------------------------------
    | DATA PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::get('/payments', [
        PaymentController::class,
        'index'
    ]);

    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI
    |--------------------------------------------------------------------------
    */

    Route::get('/payment/{id}/verify', [
        PaymentController::class,
        'verify'
    ]);

    Route::get('/payment/{id}/reject', [
        PaymentController::class,
        'reject'
    ]);

});