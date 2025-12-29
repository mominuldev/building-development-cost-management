<?php

namespace App\Providers;

use App\Models\LaborCost;
use App\Models\Worker;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        // Define morph map for polymorphic relationships
        Relation::morphMap([
            'contractor' => LaborCost::class,
            'worker' => Worker::class,
        ]);
    }
}
