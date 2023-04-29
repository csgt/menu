<?php
namespace Csgt\Menu;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{

    public function boot()
    {
        AliasLoader::getInstance()->alias('Menu', 'Csgt\Menu\Menu');
    }

    public function register()
    {
    }
}
