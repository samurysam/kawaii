<?php

use Illuminate\Support\Facades\Route;
use Webkul\UTap\Http\Controllers\Admin\PaymentLinkController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::prefix('sales/payment-links')->group(function () {
        Route::get('', [PaymentLinkController::class, 'index'])->name('admin.sales.payment_links.index');
        Route::post('store', [PaymentLinkController::class, 'store'])->name('admin.sales.payment_links.store');
        Route::get('view/{id}', [PaymentLinkController::class, 'view'])->name('admin.sales.payment_links.view');
    });
});
