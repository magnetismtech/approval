<?php

namespace Magnetism\Approval;

use Illuminate\Support\ServiceProvider;

class ApprovalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Magnetism\Approval\Http\ApprovalController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        if ($this->app->runningInConsole()) {
            // Export the migration

                $this->publishes([
                    __DIR__ . '\database\migrations\create_approval_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_approval_tables.php'),
                    // you can add any number of migrations here
                ], 'migrations');

        }
    }
}
