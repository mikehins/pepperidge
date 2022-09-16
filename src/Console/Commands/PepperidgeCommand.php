<?php

namespace Mikehins\Pepperidge\Console\Commands;

use Illuminate\Console\Command;


class PepperidgeCommand extends Command
{
    protected $signature = 'pepperidge:remembers';

    protected $description = 'Command description';

    public function handle()
    {
        $this->updatePackageDotJson();

        copy(__DIR__ . '/../../Stubs/webpack.mix.js', base_path('webpack.mix.js'));
        exec('rm vite.config.js');

        exec('npm remove vite laravel-vite-plugin lodash');
        exec('npm i laravel-mix jquery resolve-url-loader sass-loader fs path --save-dev');
        exec('composer require laravel/ui');
        exec('php artisan ui bootstrap --auth');

        $content = file_get_contents(base_path('.env'));
        $content = str_replace('VITE_', 'MIX_', $content);
        file_put_contents(base_path('.env'), $content);
		
		$content = file_get_contents(resource_path('views/layouts/app.blade.php'));
        $content = str_replace('@vite([\'resources/sass/app.scss\', \'resources/js/app.js\'])', '<link rel="stylesheet" href="{{ mix(\'/assets/css/app.css\') }}"><script src="{{ mix(\'/assets/js/app.js\') }}" defer></script>', $content);
        file_put_contents(resource_path('views/layouts/app.blade.php'), $content);
	
	    copy(__DIR__ . '/../../Stubs/app.js', resource_path('js/app.js'));
	    copy(__DIR__ . '/../../Stubs/bootstrap.js', resource_path('js/bootstrap.js'));
	    exec('cp -r ' . __DIR__ . '/../../Stubs/assets ' . resource_path('/'));
		
        exec('npm install');
        exec('npm run dev');

        $this->line('Done ! Please make sure the js and css files have been added to your template.');
        $this->line('<link rel="stylesheet" href="{{ mix(\'css/app.css\') }}"><script src="{{ mix(\'js/app.js\') }}" defer></script>');

        return 0;
    }

    private function updatePackageDotJson(): self
    {
        $content = file_get_contents(base_path('package.json'));
        $content = str_replace('"dev": "vite",', '"dev": "npm run development",
        "development": "mix",
        "watch": "mix watch",
        "watch-poll": "mix watch -- --watch-options-poll=1000",
        "hot": "mix watch --hot",
        "prod": "npm run production",
        "production": "mix --production"', $content);

        $content = str_replace('"build": "vite build"', '', $content);

        file_put_contents(base_path('package.json'), $content);

        return $this;
    }
}
