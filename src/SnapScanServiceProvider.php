<?php namespace Stephenmudere\SnapScan;

use Illuminate\Support\ServiceProvider;
use Stephenmudere\SnapScan\Handlers\SnapScanHandler;

class SnapScanServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $config_file = __DIR__.'/config/config.php';

        $this->publishes([
            $config_file => config_path('snap_scan.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SnapScanHandler', function ($app) {
            return new SnapScanHandler(new SnapScanHandler());
        });

        $this->app->alias('SnapScanHandler',SnapScanHandler::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['SnapScanHandler'];
    }
}