<?php

namespace App\Providers;

use App\Logic\Commands\ClearServicesCache;
use App\Logic\Commands\ClearSettingsCache;
use App\Logic\Commands\CreateMastodonApp;
use App\Logic\Commands\DeleteOldData;
use App\Logic\Commands\ImportAccountAudience;
use App\Logic\Commands\ImportAccountData;
use App\Logic\Commands\ProcessMetrics;
use App\Logic\Commands\RunScheduledPosts;
use App\Logic\Exceptions\SocialExceptionHandler;
use App\Logic\Services;
use App\Logic\Settings;
use App\Logic\SocialProviderManager;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function packageRegistered()
    {
        $this->app->singleton('SocialProviderManager', function ($app) {
            return new SocialProviderManager($app);
        });

        $this->app->singleton('SocialSettings', function ($app) {
            return new Settings($app);
        });

        $this->app->singleton('SocialServices', function ($app) {
            return new Services($app);
        });
    }

    public function packageBooted()
    {
        $this->registerExceptionHandler();

        Gate::define('viewSocial', function () {
            return true;
        });
    }

    protected function registerExceptionHandler(): void
    {
        app()->bind(ExceptionHandler::class, SocialExceptionHandler::class);
    }

    public function register()
    {
        $this->packageRegistered();
    }

    public function boot()
    {
        $this->packageBooted();

        $this->commands([
            ClearServicesCache::class,
            ClearSettingsCache::class,
            CreateMastodonApp::class,
            DeleteOldData::class,
            ImportAccountAudience::class,
            ImportAccountData::class,
            ProcessMetrics::class,
            RunScheduledPosts::class,
        ]);
    }
}
