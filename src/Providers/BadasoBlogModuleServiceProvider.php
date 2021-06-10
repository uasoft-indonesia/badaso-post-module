<?php

namespace Uasoft\Badaso\Module\Blog\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Uasoft\Badaso\Module\Blog\BadasoBlogModule;
use Uasoft\Badaso\Module\Blog\Commands\BadasoBlogSetup;
use Uasoft\Badaso\Module\Blog\Facades\BadasoBlogModule as FacadesBadasoBlog;

class BadasoBlogModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('BadasoBlogModule', FacadesBadasoBlog::class);

        $this->app->singleton('badaso-blog-module', function () {
            return new BadasoBlogModule();
        });

        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'badaso_blog');

        $this->publishes([
            __DIR__.'/../Config/badaso-blog.php' => config_path('badaso-blog.php'),
            __DIR__.'/../Seeder' => database_path('seeders/Badaso/Blog'),
        ], 'BadasoBlogModule');

        $this->publishes([
            __DIR__.'/../Swagger' => app_path('Http/Swagger/swagger_models'),
        ], 'BadasoBlogSwagger');
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
        $this->commands(BadasoBlogSetup::class);
    }
}
