<?php

namespace Csgt\Menu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class MenuServiceProvider extends ServiceProvider {

    public function boot() {
      $this->mergeConfigFrom(__DIR__ . '/config/csgtmenu.php', 'csgtmenu');
      $this->loadViewsFrom(__DIR__ . '/resources/views/','csgtmenu');
      AliasLoader::getInstance()->alias('Menu','Csgt\Menu\Menu');

      $this->publishes([
        __DIR__.'/database/migrations' => $this->app->databasePath() . '/migrations',
      ], 'migrations');

      $this->publishes([
        __DIR__.'/config/csgtmenu.php' => config_path('csgtmenu.php'),
      ], 'config');
    }

    public function register() {
      config([
        'config/config.php',
      ]);
    }
}