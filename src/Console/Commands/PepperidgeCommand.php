<?php

namespace Mikehins\Pepperidge\Console\Commands;

use Illuminate\Console\Command;


class PepperidgeCommand extends Command
{
	protected $signature = 'pepperidge:remembers';
	
	protected $description = 'Command description';
	
	private $data;
	
	public function handle()
	{
		$this->data = $this->data();
		
		shell_exec('composer require laravel/ui');
		shell_exec('php artisan ui bootstrap');
		if ($this->data['auth']) {
			shell_exec('php artisan ui:auth --force');
		}
		
		if ($this->data['type'] === "Vite") {
			$this->updatePackageDotJsonForVite();
			$this->line('Done ! We\'ll try to install npm... if it fails please run : npm install && npm run dev');
			shell_exec('npm install && npm run dev');
		} else {
			$this->updatePackageDotJsonForWebpack();
			$this->line('Done ! We\'ll try to install npm... if it fails please run : npm install && npm run dev && npm run hot');
			shell_exec('npm install && npm run dev && npm run hot');
		}
		
		return 0;
	}
	
	private function updatePackageDotJsonForWebpack(): void
	{
		file_put_contents(base_path('package.json'), preg_replace('/"scripts": {.*?}/s', '"scripts" : {
        "dev": "npm run development",
        "development": "mix",
        "watch": "mix watch",
        "watch-poll": "mix watch -- --watch-options-poll=1000",
        "hot": "mix watch --hot",
        "prod": "npm run production",
        "production": "mix --production"
	}', file_get_contents(base_path('package.json'))));
		
		$content = file_get_contents(__DIR__ . '/../../Stubs/webpack.mix.js');
		$content = str_replace(['{{ key }}', '{{ cert }}', '{{ domain }}'], [
			$this->data['key'],
			$this->data['cert'],
			$this->data['domain'],
		], $content);
		file_put_contents(base_path('webpack.mix.js'), $content);
		
		if (file_exists(base_path('vite.config.js'))) {
			shell_exec('rm vite.config.js');
		}
		
		shell_exec('npm remove vite laravel-vite-plugin lodash');
		shell_exec('npm i laravel-mix jquery resolve-url-loader sass-loader fs path laravel-mix-blade-reload --save-dev');
		
		$content = file_get_contents(base_path('.env'));
		$content = str_replace('VITE_', 'MIX_', $content);
		file_put_contents(base_path('.env'), $content);
		
		if (file_exists(resource_path('views/layouts/app.blade.php'))) {
			$content = file_get_contents(resource_path('views/layouts/app.blade.php'));
			$content = str_replace('@vite([\'resources/sass/app.scss\', \'resources/js/app.js\'])', '<link rel="stylesheet" href="{{ mix(\'css/app.css\') }}"><script src="{{ mix(\'js/app.js\') }}" defer></script>', $content);
			file_put_contents(resource_path('views/layouts/app.blade.php'), $content);
		}
		if (file_exists(resource_path('views/welcome.blade.php'))) {
			$content = file_get_contents(resource_path('views/welcome.blade.php'));
			$content = str_replace('@vite([\'resources/sass/app.scss\', \'resources/js/app.js\'])', '<link rel="stylesheet" href="{{ mix(\'css/app.css\') }}"><script src="{{ mix(\'js/app.js\') }}" defer></script>', $content);
			file_put_contents(resource_path('views/layouts/app.blade.php'), $content);
		}
		
		copy(__DIR__ . '/../../Stubs/app.js', resource_path('js/app.js'));
		copy(__DIR__ . '/../../Stubs/bootstrap.js', resource_path('js/bootstrap.js'));
		copy(__DIR__ . '/../../Stubs/assets', resource_path('/'));
		copy( __DIR__ . '/../../Stubs/webpack/app.blade.php', resource_path('/views/layouts'));
		copy( __DIR__ . '/../../Stubs/webpack/welcome.blade.php', resource_path('/views'));
	}
	
	private function updatePackageDotJsonForVite(): self
	{
		file_put_contents(base_path('package.json'), preg_replace('/"scripts": {.*?}/s', '"scripts" : {
        "dev": "vite",
        "build": "vite build"
	}', file_get_contents(base_path('package.json'))));
		
		file_put_contents(base_path('vite.config.js'), str_replace(
				['{{ domain }}', '{{ cert }}', '{{ key }}'],
				[
					$this->data['domain'],
					$this->data['cert'],
					$this->data['key'],
				],
				file_get_contents(__DIR__ . '/../../Stubs/vite/vite.config.js'))
		);
		
		if (file_exists(base_path('webpack.mix.js'))) {
			shell_exec('rm webpack.mix.js');
		}
		
		shell_exec('npm remove laravel-mix lodash');
		shell_exec('npm i vite laravel-vite-plugin @rollup/plugin-inject jquery resolve-url-loader sass-loader fs path --save-dev');
		
		$content = file_get_contents(base_path('.env'));
		$content = str_replace('MIX_', 'VITE_', $content);
		file_put_contents(base_path('.env'), $content);
		
		if (file_exists(resource_path('views/layouts/app.blade.php'))) {
			$content = file_get_contents(resource_path('views/layouts/app.blade.php'));
			$content = str_replace(['<link rel="stylesheet" href="{{ mix(\'css/app.css\') }}">', '<script src="{{ mix(\'js/app.js\') }}" defer></script>'], '@vite([\'resources/sass/app.scss\', \'resources/js/app.js\'])', $content);
			file_put_contents(resource_path('views/layouts/app.blade.php'), $content);
		}
		if (file_exists(resource_path('views/welcome.blade.php'))) {
			file_put_contents(resource_path('views/welcome.blade.php'),
				str_replace(['<link rel="stylesheet" href="{{ mix(\'css/app.css\') }}">', '<script src="{{ mix(\'js/app.js\') }}" defer></script>'], '@vite([\'resources/sass/app.scss\', \'resources/js/app.js\'])',
					file_get_contents(resource_path('views/welcome.blade.php'))));
		}
		
		copy(__DIR__ . '/../../Stubs/vite/welcome.blade.php', resource_path('/views'));
		copy(__DIR__ . '/../../Stubs/vite/app.js', resource_path('js/app.js'));
		copy(__DIR__ . '/../../Stubs/vite/bootstrap.js', resource_path('js/bootstrap.js'));
		copy(__DIR__ . '/../../Stubs/assets', resource_path('/'));
		
		return $this;
	}
	
	private function data(): array
	{
		return [
			'type'   => $this->choice('type', [1 => 'Vite', 2 => 'webpack']),
			'auth'   => $this->confirm('With authentification ?'),
			'domain' => $this->ask('What is the domain name ?'),
			'cert'   => $this->anticipate('SSL Certificates path', ['/usr/local/etc/nginx/cert-fullchain.pem', '/etc/letsencrypt/live/hins.dev/fullchain.pem']),
			'key'    => $this->anticipate('SSL private key path', ['/usr/local/etc/nginx/cert-privkey.pem', '/etc/letsencrypt/live/hins.dev/privkey.pem']),
		];
	}
}
