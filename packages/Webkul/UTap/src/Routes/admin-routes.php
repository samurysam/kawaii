<?php

use Illuminate\Support\Facades\Route;
use Webkul\UTap\Http\Controllers\Admin\PaymentLinkController;
use Webkul\UTap\Http\Controllers\Admin\QRPaymentController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    // 1. Admin Generated Payment Links Dashboard
    Route::prefix('sales/payment-links')->group(function () {
        Route::get('', [PaymentLinkController::class, 'index'])->name('admin.sales.payment_links.index');
        Route::post('store', [PaymentLinkController::class, 'store'])->name('admin.sales.payment_links.store');
        Route::get('view/{id}', [PaymentLinkController::class, 'view'])->name('admin.sales.payment_links.view');
        Route::post('resend-receipt/{id}', [PaymentLinkController::class, 'resendReceipt'])->name('admin.sales.payment_links.resend_receipt');
        Route::post('mark-paid/{id}', [PaymentLinkController::class, 'markPaid'])->name('admin.sales.payment_links.mark_paid');
    });

    // 2. Dedicated QR Payments Dashboard
    Route::prefix('sales/qr-payments')->group(function () {
        Route::get('', [QRPaymentController::class, 'index'])->name('admin.sales.qr_payments.index');
        Route::get('view/{id}', [QRPaymentController::class, 'view'])->name('admin.sales.qr_payments.view');
        Route::post('resend-receipt/{id}', [QRPaymentController::class, 'resendReceipt'])->name('admin.sales.qr_payments.resend_receipt');
        Route::post('mark-paid/{id}', [QRPaymentController::class, 'markPaid'])->name('admin.sales.qr_payments.mark_paid');
    });
});
