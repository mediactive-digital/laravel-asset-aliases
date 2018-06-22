<?php

namespace MediactiveDigital\LaravelAssetAliases;

use \Illuminate\Support\ServiceProvider;

class LaravelAssetAliasesServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config' => config_path('laravel-asset-aliases'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(AssetManager::class, function() {
            return new AssetManager();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/config/alias.php', 'alias'
        );
    }

    public function provides()
    {
        return [AssetManager::class];
    }
}
