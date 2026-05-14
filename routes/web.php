<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;

use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Resident\PaymentController as ResidentPaymentController;

use App\Http\Controllers\ImportPaymentController;
use App\Http\Controllers\CashReportController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SummaryCashReportController;
use App\Http\Controllers\ResidentController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    /*
    |--------------------------------------------------------------------------
    | BELUM LOGIN
    |--------------------------------------------------------------------------
    */

    if (!auth()->check()) {

        return redirect('/login');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    if (auth()->user()->role == 'admin') {

        return redirect('/dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | WARGA
    |--------------------------------------------------------------------------
    */

    return redirect('/payment');

});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [
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
| USER AREA
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
    | CASH REPORT
    |--------------------------------------------------------------------------
    */

    Route::get('/cash-report', [
        CashReportController::class,
        'index'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PAYMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/payment', [
        ResidentPaymentController::class,
        'create'
    ]);

    Route::post('/payment', [
        ResidentPaymentController::class,
        'store'
    ]);

    /*
    |--------------------------------------------------------------------------
    | HISTORY
    |--------------------------------------------------------------------------
    */

    Route::get('/payment-history', [
        ResidentPaymentController::class,
        'history'
    ]);

    /*
    |--------------------------------------------------------------------------
    | ACCOUNT
    |--------------------------------------------------------------------------
    */

    Route::get('/account', [
        ProfileController::class,
        'index'
    ]);

    Route::post('/account', [
        ProfileController::class,
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
    | IMPORT PAYMENT
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
    | PAYMENTS
    |--------------------------------------------------------------------------
    */

    Route::get('/payments', [
        AdminPaymentController::class,
        'index'
    ]);

    Route::get('/payment/{id}/verify', [
        AdminPaymentController::class,
        'verify'
    ]);

    Route::get('/payment/{id}/reject', [
        AdminPaymentController::class,
        'reject'
    ]);

    /*
    |--------------------------------------------------------------------------
    | EXPENSES
    |--------------------------------------------------------------------------
    */

    Route::get('/expenses', [
        ExpenseController::class,
        'index'
    ]);

    Route::post('/expenses', [
        ExpenseController::class,
        'store'
    ]);

    /*
    |--------------------------------------------------------------------------
    | SUMMARY REPORT
    |--------------------------------------------------------------------------
    */

    Route::get('/summary-report', [
        SummaryCashReportController::class,
        'index'
    ]);

    Route::middleware('auth')->group(function () {

    Route::resource(
            'residents',
            ResidentController::class
        );

    });

});