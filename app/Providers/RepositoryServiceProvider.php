<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ReservationRepositoryInterface;
use App\Repositories\ReservationRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
