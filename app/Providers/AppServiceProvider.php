<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $key = $request->ip().'|'.$request->input('email');

            return Limit::perMinute(5)
                ->by($key)
                ->response(function () use ($request, $key) {

                    $seconds = RateLimiter::availableIn(md5('login'.$key));

                    return back()
                        ->withErrors([
                            'email' => "Слишком много попыток. Подождите {$seconds} сек.",
                        ])
                        ->with('throttle_seconds', $seconds);


                });
        });
        RateLimiter::for('register', function (Request $request) {
            $key = $request->ip().'|'.$request->input('email');

            return Limit::perMinute(5)
                ->by($key)
                ->response(function () use ($request, $key) {

                    $seconds = RateLimiter::availableIn(md5('register'.$key));

                    return back()
                        ->withErrors([
                            'email' => "Слишком много попыток. Подождите {$seconds} сек.",
                        ])
                        ->with('throttle_seconds', $seconds);


                });
        });
    }
}
