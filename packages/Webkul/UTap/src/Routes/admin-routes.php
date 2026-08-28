<?php

use Illuminate\Support\Facades\Route;
use Webkul\UTap\Http\Controllers\Admin\PaymentLinkController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::prefix('sales/payment-links')->group(function () {
        Route::get('', [PaymentLinkController::class, 'index'])->name('admin.sales.payment_links.index');
        Route::post('store', [PaymentLinkController::class, 'store'])->name('admin.sales.payment_links.store');
        Route::get('view/{id}', [PaymentLinkController::class, 'view'])->name('admin.sales.payment_links.view');
        Route::post('resend-receipt/{id}', [PaymentLinkController::class, 'resendReceipt'])->name('admin.sales.payment_links.resend_receipt');
        Route::post('mark-paid/{id}', [PaymentLinkController::class, 'markPaid'])->name('admin.sales.payment_links.mark_paid');
    });
});
