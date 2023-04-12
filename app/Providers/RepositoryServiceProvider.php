<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PhotoRepositoryInterface;
use App\Repositories\photoRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PhotoRepositoryInterface::class, photoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
