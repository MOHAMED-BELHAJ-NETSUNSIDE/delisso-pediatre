<?php

namespace App\Providers;

use App\Auth\LegacyCredentialUserProvider;
use Illuminate\Support\Facades\Auth;
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
        Auth::provider('eloquent', function ($app, array $config) {
            return new LegacyCredentialUserProvider($app['hash'], $config['model']);
        });

        if ($this->app->runningInConsole() || request()->getHttpHost() === '') {
            return;
        }

        config([
            'filesystems.disks.public.url' => rtrim(request()->getSchemeAndHttpHost(), '/').'/media',
        ]);
    }
}
