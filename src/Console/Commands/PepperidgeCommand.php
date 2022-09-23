<?php

namespace Mikehins\Pepperidge\Console\Commands;

use Mikehins\Pepperidge\Vite;
use Illuminate\Console\Command;
use Mikehins\Pepperidge\Webpack;


class PepperidgeCommand extends Command
{
	protected $signature = 'pepperidge:remembers';
	
	protected $description = 'Command description';
	
	private $data;
	
	public function handle()
	{
		$this->data = $this->data();
		$this->installLaravelUI();
		$this->makeAuth();
		
		$this->data['type'] === 'Vite'
			? (new Vite($this->data))->handle()
			: (new Webpack($this->data))->handle();
		
		$this->line('');
		$this->data['type'] === 'Vite'
			? $this->info('Please run npm install && npm run dev')
			: $this->info('Please run npm install && npm run dev && npm run hot');
		$this->line('');
		
		
		return 0;
	}
	
	private function installLaravelUI(): void
	{
		shell_exec('composer require laravel/ui');
		shell_exec('php artisan ui bootstrap');
	}
	
	private function makeAuth(): void
	{
		if ($this->data['auth'] === 'yes') {
			shell_exec('php artisan ui:auth --force');
		}
	}
	
	private function data(): array
	{
		return [
			'type'   => $this->choice('type', [1 => 'Vite', 2 => 'webpack']),
			'auth'   => $this->choice('With authentification ?', ['yes', 'no']),
			'domain' => $this->ask('What is the domain name ?'),
			'cert'   => $this->anticipate('SSL Certificates path', ['/usr/local/etc/nginx/cert-fullchain.pem', '/etc/letsencrypt/live/hins.dev/fullchain.pem']),
			'key'    => $this->anticipate('SSL private key path', ['/usr/local/etc/nginx/cert-privkey.pem', '/etc/letsencrypt/live/hins.dev/privkey.pem']),
		];
	}
}
