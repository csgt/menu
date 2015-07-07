<?php

namespace Csgt\Menu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class MenuServiceProvider extends ServiceProvider {

    public function boot() {
      //$this->package('csgt/menu');
      $this->mergeConfigFrom(__DIR__ . '/config/csgtmenu.php', 'csgtmenu');
      $this->loadViewsFrom(__DIR__ . '/resources/views/','csgtmenu');
      AliasLoader::getInstance()->alias('Menu','Csgt\Menu\Menu');
    }

    public function register() {
      config([
        'config/config.php',
      ]);
    }
}