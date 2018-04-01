<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 2.4.18.
 * Time: 01.02
 */

namespace Rackbeat;


use Illuminate\Support\ServiceProvider;
class RackbeatServiceProvider extends ServiceProvider
{
    /**
     * Boot.
     */
    public function boot()
    {
        $configPath = __DIR__.'/config/rackbeat.php';

        $this->mergeConfigFrom($configPath, 'economic');

        $configPath = __DIR__.'/config/rackbeat.php';

        if (function_exists('config_path')) {

            $publishPath = config_path('rackbeat.php');

        } else {

            $publishPath = base_path('config/rackbeat.php');

        }

        $this->publishes([$configPath => $publishPath], 'config');
    }
    public function register()
    {
    }
}