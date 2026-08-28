<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Webkul\UTap\Http\Controllers\UTapController;

Route::controller(UTapController::class)
    ->middleware('web')
    ->prefix('utap')
    ->group(function () {
        Route::get('redirect', 'redirect')->name('utap.redirect');

        Route::match(['get', 'post'], 'callback/{cartId?}', 'callback')
            ->withoutMiddleware([
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
            ])
            ->name('utap.callback');

        Route::get('success', 'success')->name('utap.success');
    });
