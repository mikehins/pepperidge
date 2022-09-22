<?php

namespace Mikehins\Pepperidge;

class Webpack
{
	public function __construct(private array $data)
	{
	}
	
	public function handle(): int
	{
		$this->updatePackageDotJson();
		$this->updateMixFile();
		$this->cleanUp();
		$this->installJsDependencies();
		$this->updateENVFile();
		$this->copyStubs();
		$this->runNpm();
		
		return 0;
	}
	
	private function updatePackageDotJson(): void
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
	}
	
	private function updateMixFile()
	{
		$content = file_get_contents(__DIR__ . '/Stubs/webpack.mix.js');
		$content = str_replace(['{{ key }}', '{{ cert }}', '{{ domain }}'], [
			$this->data['key'],
			$this->data['cert'],
			$this->data['domain'],
		], $content);
		file_put_contents(base_path('webpack.mix.js'), $content);
	}
	
	private function cleanUp(): void
	{
		if (file_exists(base_path('vite.config.js'))) {
			shell_exec('rm vite.config.js');
		}
		
		shell_exec('npm remove vite laravel-vite-plugin lodash');
	}
	
	private function installJsDependencies()
	{
		shell_exec('npm i laravel-mix jquery resolve-url-loader sass-loader fs path laravel-mix-blade-reload --save-dev');
	}
	
	private function updateENVFile(): void
	{
		file_put_contents(base_path('.env'),
			str_replace(
				'VITE_', 'MIX_', file_get_contents(base_path('.env'))
			)
		);
	}
	
	private function copyStubs(): void
	{
		copy(__DIR__ . '/Stubs/app.js', resource_path('js/app.js'));
		copy(__DIR__ . '/Stubs/bootstrap.js', resource_path('js/bootstrap.js'));
		shell_exec('cp -r ' . __DIR__ . '/Stubs/assets ' . resource_path('/'));
		shell_exec('cp -r ' . __DIR__ . '/Stubs/webpack/app.blade.php ' . resource_path('/views/layouts'));
		shell_exec('cp -r ' . __DIR__ . '/Stubs/webpack/welcome.blade.php ' . resource_path('/views'));
	}
	
	private function runNpm(): void
	{
		shell_exec('npm install && npm run dev && npm run hot');
	}
}