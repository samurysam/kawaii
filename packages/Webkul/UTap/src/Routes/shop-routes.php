<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Webkul\UTap\Http\Controllers\Shop\PublicPaymentLinkController;

Route::group(['middleware' => ['web']], function () {
    // Public Open Quick-Pay form (QR link)
    Route::get('pay', [PublicPaymentLinkController::class, 'openPay'])->name('payment_link.open_pay');
    Route::post('pay', [PublicPaymentLinkController::class, 'submitOpenPay'])->name('payment_link.open_pay.submit');

    // Direct Payment Link checkout
    Route::get('pay/{linkCode}', [PublicPaymentLinkController::class, 'checkout'])->name('payment_link.checkout');
    Route::post('pay/{linkCode}/process', [PublicPaymentLinkController::class, 'process'])->name('payment_link.process');

    // Callback from uTap
    Route::match(['get', 'post'], 'pay/{linkCode}/callback', [PublicPaymentLinkController::class, 'callback'])
        ->withoutMiddleware([
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
        ])
        ->name('payment_link.callback');

    // Official Receipt
    Route::get('pay/{linkCode}/receipt', [PublicPaymentLinkController::class, 'receipt'])->name('payment_link.receipt');
});
