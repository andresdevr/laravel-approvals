<?php

namespace Andresdevr\LaravelApprovals;

use Andresdevr\LaravelApprovals\Console\Commands\PublishMigrations;
use Illuminate\Support\ServiceProvider;

class ApprovalsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->runningInConsole()) 
        {
            $this->publishes([
                __DIR__ . '/../config/approvals.php' => config_path('approvals.php'),
            ], 'approvals-config');

            if(! class_exists('CreatePendingChangesTable'))
            {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_pending_changes_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_pending_changes_table.php')
                ], 'approvals-migrations');
            }

            $this->commands([
                PublishMigrations::class
            ]);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/approvals.php', 'approvals');
    }
}