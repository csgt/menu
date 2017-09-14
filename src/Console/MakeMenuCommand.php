<?php

namespace Csgt\Menu\Console;

use Illuminate\Console\Command;

class MakeMenuCommand extends Command {

  protected $signature = 'make:csgtmenu';

  protected $description = 'Vista para Menu';

  protected $views = [
    'layout/menu.stub' => 'layouts/menu.blade.php',
  ];

  public function handle() {
    $this->exportViews();
    $this->info('Vistas para Menu generadas.');
  }

  protected function exportViews() {
    foreach ($this->views as $key => $value) {
      copy(
        __DIR__.'/stubs/make/views/'.$key,
        base_path('resources/views/'.$value)
      );
    }
  }

}
