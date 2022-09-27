<?php

namespace Mikehins\Pepperidge;

class Vite
{
	public function __construct(private array $data)
	{
	}
	
	public function handle(): int
	{
		$this->updatePackageDotJson();
		$this->updateViteConfig();
		$this->cleanUp();
		$this->installJsDependencies();
		$this->updateENVFile();
		$this->copyStubs();
		
		return 0;
	}
	
	private function updatePackageDotJson(): void
	{
		file_put_contents(base_path('package.json'), preg_replace('/"scripts": {.*?}/s', '"scripts" : {
        "dev": "vite",
        "build": "vite build"
	}', file_get_contents(base_path('package.json'))));
	}
	
	private function updateViteConfig(): void
	{
		$findReplace = [
			'{{ key }}'    => $this->data['key'],
			'{{ cert }}'   => $this->data['cert'],
			'{{ domain }}' => $this->data['domain'],
		];
		
		file_put_contents(base_path('vite.config.js'),
			str_replace(array_keys($findReplace), array_values($findReplace), file_get_contents(__DIR__ . '/Stubs/vite/vite.config.js'))
		);
	}
	
	private function cleanUp(): void
	{
		if (file_exists(base_path('webpack.mix.js'))) {
			shell_exec('rm webpack.mix.js');
		}
		
		shell_exec('npm remove laravel-mix lodash');
	}
	
	private function installJsDependencies(): void
	{
		shell_exec('npm i vite laravel-vite-plugin @rollup/plugin-inject jquery resolve-url-loader sass-loader fs path --save-dev');
	}
	
	private function updateENVFile(): void
	{
		file_put_contents(base_path('.env'),
			str_replace(
				'MIX_', 'VITE_', file_get_contents(base_path('.env'))
			)
		);
	}
	
	protected function copyStubs(): void
	{
		copy(__DIR__ . '/Stubs/vite/app.blade.php', resource_path('/views/layouts/app.blade.php'));
		copy(__DIR__ . '/Stubs/vite/welcome.blade.php', resource_path('/views/welcome.blade.php'));
		copy(__DIR__ . '/Stubs/vite/app.js', resource_path('js/app.js'));
		copy(__DIR__ . '/Stubs/vite/bootstrap.js', resource_path('js/bootstrap.js'));
		shell_exec('cp -r ' . __DIR__ . '/Stubs/assets ' . resource_path('/'));
	}
}