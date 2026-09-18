<?php

use App\Http\Middleware\EncryptCookies;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Webkul\Core\Http\Middleware\SecureHeaders;
use Webkul\Installer\Http\Middleware\CanInstall;

if (! function_exists('mb_split')) {
    function mb_split(string $pattern, string $string, int $limit = -1): array|false
    {
        $delimiter = '/';
        $escaped = str_replace($delimiter, '\\'.$delimiter, $pattern);
        $result = preg_split($delimiter.$escaped.$delimiter.'u', $string, $limit);

        return $result !== false ? $result : false;
    }
}

if (! function_exists('mb_ereg_replace')) {
    function mb_ereg_replace(string $pattern, string $replacement, string $string, ?string $options = null): string|false
    {
        $delimiter = '/';
        $escaped = str_replace($delimiter, '\\'.$delimiter, $pattern);
        $modifiers = 'u'.(str_contains((string) $options, 'i') ? 'i' : '');
        $result = preg_replace($delimiter.$escaped.$delimiter.$modifiers, $replacement, $string);

        return $result !== null ? $result : false;
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /**
         * Remove the default Laravel middleware that prevents requests during maintenance mode. There are three
         * middlewares in the shop that need to be loaded before this middleware. Therefore, we need to remove this
         * middleware from the list and add the overridden middleware at the end of the list.
         *
         * As of now, this has been added in the Admin and Shop providers. I will look for a better approach in Laravel 11 for this.
         */
        $middleware->remove(PreventRequestsDuringMaintenance::class);

        /**
         * Remove the default Laravel middleware that converts empty strings to null. First, handle all nullable cases,
         * then remove this line.
         */
        $middleware->remove(ConvertEmptyStringsToNull::class);

        $middleware->append(SecureHeaders::class);
        $middleware->append(CanInstall::class);

        /**
         * Add the overridden middleware at the end of the list.
         */
        $middleware->replaceInGroup('web', BaseEncryptCookies::class, EncryptCookies::class);

        $middleware->validateCsrfTokens(except: [
            'stripe/*',
        ]);

        $middleware->trustProxies(at: '*');
    })
    ->withSchedule(function (Schedule $schedule) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
