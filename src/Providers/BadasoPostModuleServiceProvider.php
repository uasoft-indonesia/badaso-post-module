<?php

namespace Uasoft\Badaso\Module\Post\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Uasoft\Badaso\Module\Post\BadasoPostModule;
use Uasoft\Badaso\Module\Post\Commands\BadasoPostSetup;
use Uasoft\Badaso\Module\Post\Commands\BadasoPostTestSetup;
use Uasoft\Badaso\Module\Post\Facades\BadasoPostModule as FacadesBadasoPost;

class BadasoPostModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('BadasoPostModule', FacadesBadasoPost::class);

        $this->app->singleton('badaso-post-module', function () {
            return new BadasoPostModule();
        });

        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'badaso_post');

        $this->publishes([
            __DIR__.'/../Config/badaso-post.php' => config_path('badaso-post.php'),
            __DIR__.'/../Seeder' => database_path('seeders/Badaso/Post'),
        ], 'BadasoPostModule');

        $this->publishes([
            __DIR__.'/../Swagger' => app_path('Http/Swagger/swagger_models'),
        ], 'BadasoPostSwagger');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommands();
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(BadasoPostSetup::class);
        $this->commands(BadasoPostTestSetup::class);
    }
}
