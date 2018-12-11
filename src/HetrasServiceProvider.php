<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 2.4.18.
 * Time: 01.02
 */

namespace Hetras;


use Illuminate\Support\ServiceProvider;

class HetrasServiceProvider extends ServiceProvider
{
    /**
     * Boot.
     */
    public function boot()
    {
        $configPath = __DIR__ . '/config/hetras.php';

        $this->mergeConfigFrom( $configPath, 'hetras' );

        $configPath = __DIR__ . '/config/hetras.php';

        if ( function_exists( 'config_path' ) ) {

            $publishPath = config_path( 'hetras.php' );

        } else {

            $publishPath = base_path( 'config/hetras.php' );

        }

        $this->publishes( [ $configPath => $publishPath ], 'config' );
    }

    public function register()
    {
    }
}