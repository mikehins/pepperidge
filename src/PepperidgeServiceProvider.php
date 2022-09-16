<?php

namespace Mikehins\Pepperidge;

use Illuminate\Support\ServiceProvider;
use Mikehins\Pepperidge\Console\Commands\PepperidgeCommand;

class PepperidgeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            PepperidgeCommand::class
        ]);
    }

    public function boot()
    {

    }
}
