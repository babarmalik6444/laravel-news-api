<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Domains\DataSources\Contracts\NewsManagementInterface;
use App\Domains\DataSources\Services\NewsAiApiService;
use App\Domains\DataSources\Services\NYTApiService;
use App\Domains\DataSources\Drivers\NewsApiDriver;

use App\Domains\User\Contracts\UserManagementInterface;
use App\Domains\User\Services\UserManagementService;

use App\Domains\Auth\Contracts\AuthManagementInterface;
use App\Domains\Auth\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NewsManagementInterface::class, function ($app) {
            return [
                $app->make(NYTApiService::class),
                $app->make(NewsAiApiService::class),
            ];
        });

        $this->app->bind('NewsApiDriver', function ($app) {
            $apiServices = $app->make(NewsManagementInterface::class);
            return new NewsApiDriver($apiServices);
        });

        //bind domains
        $this->app->bind(UserManagementInterface::class, UserManagementService::class);
        $this->app->bind(AuthManagementInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
