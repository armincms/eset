<?php

namespace Armincms\Eset;
 
use Illuminate\Support\ServiceProvider; 
use Laravel\Nova\Nova; 

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {  
        $this->loadMigrationsFrom( __DIR__.'/../database/migrations');
        $this->mergeConfigFrom( __DIR__.'/../config/operators.php', 'licence-management.operators.eset');
        $this->mergeConfigFrom( __DIR__.'/../config/ftp.php', 'filesystems.disks.eset');  

        Nova::serving([$this, 'servingNova']);

        $this->map(); 
    }  

    public function map()
    {
        $this
            ->app['router']   
            ->namespace(__NAMESPACE__.'\Http\Controllers')  
            ->prefix('api')
            ->group(function($router) {
                $router->match('get', 'eset/setting', 'SettingController@handle');
                $router->match('get', 'eset/validate', 'ValidationController@handle'); 
                $router->match('post', 'eset/device', 'DeviceController@handle');  
            });
    }

    public function servingNova()
    {
        Nova::resources([
            Eset::class,
        ]);
    }
}
