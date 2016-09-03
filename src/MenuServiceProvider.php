<?php

namespace Csgt\Menu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class MenuServiceProvider extends ServiceProvider {

  public function boot() {
    $this->mergeConfigFrom(__DIR__ . '/config/csgtmenu.php', 'csgtmenu');
    $this->loadTranslationsFrom(__DIR__.'/resources/lang/', 'csgtmenu');
    AliasLoader::getInstance()->alias('Menu','Csgt\Menu\Menu');

    $this->publishes([
      __DIR__.'/database/migrations' => $this->app->databasePath() . '/migrations',
    ], 'migrations');

    $this->publishes([
      __DIR__.'/config/csgtmenu.php' => config_path('csgtmenu.php'),
    ], 'config');

    $this->publishes([
      __DIR__.'/resources/lang/' => base_path('/resources/lang/vendor/csgtmenu'),
    ], 'lang');
  }

  public function register() {
    $this->commands([
      Console\MakeMenuCommand::class
    ]);

    config([
      'config/config.php',
    ]);
  }
}