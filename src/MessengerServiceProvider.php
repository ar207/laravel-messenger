<?php

namespace mar\messenger;

use mar\messenger\Contracts\UserResolver;
use mar\messenger\Helpers\Messenger;
use mar\messenger\Console\InstallCommand;
use mar\messenger\Console\PublishCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MessengerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Messenger', Messenger::class);

        $this->app->bind(UserResolver::class, function ($app) {
            return $app->make(config('messenger.user_resolver'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Load Views and Routes
        $this->loadViewsFrom(__DIR__ . '/views', 'messenger');
        $this->loadRoutes();

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                PublishCommand::class,
            ]);
            $this->setPublishes();
        }
    }

    /**
     * Publishing the files that the user may override.
     *
     * @return void
     */
    protected function setPublishes()
    {
        // Config
        $this->publishes([
            __DIR__ . '/config/messenger.php' => config_path('messenger.php')
        ], 'messenger-config');

        // Migrations
        $this->publishes([
            __DIR__.'/database/migrations/2023_12_22_999999_add_is_active_users_table.php'
            => $this->getMigrationFileName('add_is_active_users_table.php', 1),

            __DIR__.'/database/migrations/2023_12_18_999999_create_messages_table.php'
            => $this->getMigrationFileName('create_messages_table.php', 2),

            __DIR__.'/database/migrations/2023_12_30_999999_add_messenger_mode_to_users_table.php'
            => $this->getMigrationFileName('add_messenger_mode_to_users_table.php', 3),

            __DIR__.'/database/migrations/2026_03_06_999999_add_sender_type_and_receiver_to_messages_table.php'
            => $this->getMigrationFileName('add_sender_type_and_receiver_to_messages_table.php', 4),

        ], 'messenger-migrations');

        // Views
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/')
        ], 'messenger-views');

        // Assets
        $this->publishes([
            // CSS
            __DIR__ . '/assets/css' => public_path('laravel-messenger/css'),
            // JavaScript
            __DIR__ . '/assets/js' => public_path('laravel-messenger/js'),
            // Fonts
            __DIR__ . '/assets/fonts' => public_path('laravel-messenger/fonts'),
            __DIR__ . '/assets/webfonts' => public_path('laravel-messenger/webfonts'),
            // Images
            __DIR__ . '/assets/images' => public_path('laravel-messenger/images'),
            // Lib
            __DIR__ . '/assets/libs' => public_path('laravel-messenger/libs'),
        ], 'messenger-assets');
    }

    /**
     * Determine the migration file path for publishing.
     *
     * This method checks whether a migration with the given name already exists
     * in the application's migrations directory. If it exists, the existing
     * migration path is returned to prevent publishing duplicate migrations
     * with a different timestamp.
     *
     * If no existing migration is found, a new migration file path is generated
     * using the current timestamp. This ensures the migration can be published
     * normally.
     *
     * This approach helps avoid duplicate migrations when users run:
     * `php artisan vendor:publish --tag=messenger-migrations`
     * multiple times or when the package is updated.
     *
     * @param string $migrationFileName The base migration filename without timestamp.
     * @param $migrationNumber
     * @return string The path where the migration should be published.
     */
    protected function getMigrationFileName($migrationFileName, $migrationNumber)
    {
        $timestamp = date('Y_m_d_His') . $migrationNumber;

        $migrationPath = database_path('migrations/'.$timestamp.'_'.$migrationFileName);

        $existing = glob(database_path('migrations/*_'.$migrationFileName));

        if (!empty($existing)) {
            return $existing[0];
        }

        return $migrationPath;
    }

    /**
     * Group the routes and set up configurations to load them.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        Route::group($this->routesConfigurations(), function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });
    }

    /**
     * Routes configurations.
     *
     * @return array
     */
    private function routesConfigurations()
    {
        return [
            'prefix' => config('messenger.routes.prefix'),
            'namespace' =>  config('messenger.routes.namespace'),
            'middleware' => config('messenger.routes.middleware'),
        ];
    }
}