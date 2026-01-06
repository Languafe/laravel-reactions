<?php

namespace Languafe\Reactions;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ReactionsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Use defaults when the package user has not published config file
        $this->mergeConfigFrom(
            __DIR__.'/../config/reactions.php', 'reactions'
        );
    }

    public function boot()
    {
        // We need to create a `reactions` table
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // HTTP endpoints for reactions to enable out-of-the-box components
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Some "batteries-included" anonymous blade components
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'reactions');

        // Register Livewire component
        Livewire::component('reactions:panel', \Languafe\Reactions\Livewire\ReactionsPanel::class);

        // Allow users of this package to publish the config file
        $this->publishes([
            __DIR__.'/../config/reactions.php' => config_path('reactions.php'),
        ], 'reactions-config');

        // Allow users of this package to publish views in order to modify them
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/reactions'),
        ], 'reactions-views');
    }
}
