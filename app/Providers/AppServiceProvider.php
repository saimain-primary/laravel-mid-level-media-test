<?php

namespace App\Providers;

use App\Services\PostService;
use App\Services\MediaService;
use App\Contracts\PostServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Contracts\MediaServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MediaServiceInterface::class, MediaService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
