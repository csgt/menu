<?php
namespace Csgt\Cancerbero\Console;

use Illuminate\Console\Command;
use Csgt\Cancerbero\MakeCommand;

class MakeCancerberoCommand extends Command
{
    use MakeCommand;

    protected $signature = 'make:csgtmenu';

    protected $description = 'Menu model';

    protected $views = [];

    protected $directories = [
        'app/Models/Menu',
    ];

    protected $models = [
        'Menu/Menu',
    ];

    public function handle()
    {
        $this->createDirectories($this->directories);
        $this->exportModels($this->models);
        $this->info('Menu model generated succesfully.');
    }
}
