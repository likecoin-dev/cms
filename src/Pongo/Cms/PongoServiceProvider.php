<?php namespace Pongo\Cms;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader as AliasLoader;

class PongoServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Get an instance of AliasLoader
	 * 
	 * @return instance
	 */
	protected $aliasLoader;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('pongocms/cms');

		// Instantiate AliasLoader
		$this->aliasLoader = AliasLoader::getInstance();

		// Run accessor methods
		$this->loadServiceProviders();
		$this->bindServices();
		$this->bindRepositories();
		$this->activateFacades();
		$this->bootCommands();

		// Inclusions
		require __DIR__.'/../../start.php';
		require __DIR__.'/../../helpers.php';
		require __DIR__.'/../../composers.php';
		require __DIR__.'/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{		
		$app = $this->app;
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
	 * Bind managers
	 * 
	 * @return void
	 */
	protected function bindManagers()
	{
		$app = $this->app;
		$managers = $app['config']['cms::system.managers'];

		foreach ($managers as $manager) {			
			$app->$manager['method']($manager['interface'], $manager['class']);
		}
	}

	/**
	 * Bind repositories
	 *
	 * @return void
	 */
	protected function bindRepositories()
	{		
		$app = $this->app;
		$repositories = $app['config']['cms::system.repositories'];

		foreach ($repositories as $repo) {
			$app->$repo['method']($repo['interface'], $repo['class']);
		}
	}

	/**
	 * Bind services
	 * 
	 * @return void
	 */
	protected function bindServices()
	{
		$app = $this->app;
		$services = $app['config']['cms::system.services'];

		foreach ($services as $service) {			
			$app->$service['method']($service['interface'], $service['class']);
		}
	}

	/**
	 * Activate custom Facades
	 *
	 * @return void
	 */
	protected function activateFacades()
	{
		$app = $this->app;
		$facades = $app['config']['cms::system.facades'];
		
		foreach ($facades as $facade => $path) {
			$injections = array();
			if(is_array($path['depes'])) {
				foreach ($path['depes'] as $depinj) {
					$injections[] = (array_key_exists('interface', $depinj)) ?
						$this->app->make($depinj['interface']) : new $depinj['class'];
				}
			}			
			// Share facade name
			$app[$facade] = $app->share(function($app) use ($path, $injections) {
				return $this->createInstance($path['class'], $injections);
			});
			// Alias facade
			$app->booting(function() use ($facade, $path) {
				$this->aliasLoader->alias($facade, $path['alias']);
			});			
		}
	}

	/**
	 * Load custom service providers
	 *
	 * @return void
	 */
	protected function loadServiceProviders()
	{
		$app = $this->app;
		$providers = $app['config']['cms::system.providers'];
		$provider_path = 'Pongo\Cms\Support\Providers\\';	

		foreach ($providers as $provider) {
			if (substr_count($provider, '\\')>0) $provider_path = '';
			$provider_name = "{$provider_path}{$provider}";
			$app->register($provider_name);
		}
	}

	/**
	 * Load custom Artisan commands
	 *
	 * @return void
	 */
	protected function bootCommands()
	{
		$app = $this->app;
		$commands = $app['config']['cms::system.commands'];

		foreach ($commands as $command => $class) {			
			$this->app[$command] = $this->app->share(function($app) use ($class) {
				return $this->createInstance($class);
			});
			$reg_commands[] = $command;
		}

		$this->commands($reg_commands);
	}

	/**
	 * Instantiate a class with dependency classes
	 * 
	 * @param  class $class
	 * @param  array $params
	 * @return obj
	 */
	private function createInstance($class, $params = array())
	{
		$reflection_class = new \ReflectionClass($class);		
		return $reflection_class->newInstanceArgs($params);
	}

}