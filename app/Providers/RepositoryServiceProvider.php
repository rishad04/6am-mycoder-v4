<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SubscriptionPlan\SubscriptionPlanInterface;
use App\Repositories\SubscriptionPlan\SubscriptionPlanRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Binding the SubscriptionPlanInterface to its concrete implementation
        $this->app->bind(SubscriptionPlanInterface::class, SubscriptionPlanRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
