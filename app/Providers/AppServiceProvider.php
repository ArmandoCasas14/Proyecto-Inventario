<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

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
    public function boot(UrlGenerator $url)
    {
        Mail::extend('brevo', function () {
            return (new BrevoTransportFactory())
                ->create(
                    new Dsn(
                        'brevo+api',
                        'default',
                        config('services.brevo.key')
                    )
                );
        });

        if (env('APP_ENV') === 'production') {
            $url->forceScheme('https');
        }
    }
}