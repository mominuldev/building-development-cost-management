<?php

namespace App\Providers;

use App\Models\LaborCost;
use App\Models\Worker;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;

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

        // Blade directive for settings
        Blade::if('setting', function ($key, $operator = null, $value = null) {
            if ($operator === null) {
                return \App\Models\Settings::get($key);
            }

            if ($operator === '=') {
                return \App\Models\Settings::get($key) === $value;
            }

            if ($operator === '!=') {
                return \App\Models\Settings::get($key) !== $value;
            }

            return \App\Models\Settings::get($key);
        });
    }
}
