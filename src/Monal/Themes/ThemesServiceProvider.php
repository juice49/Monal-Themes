<?php
namespace Monal\Themes;

use Illuminate\Support\ServiceProvider;

class ThemesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var		Boolean
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return	Void
	 */
	public function boot()
	{
		$this->package('monal/themes');
	}

	/**
	 * Register the service provider.
	 *
	 * @return	Void
	 */
	public function register()
	{
		$routes = __DIR__.'/../../routes.php';
		if (file_exists($routes)){
			include $routes;
		}

		\Monal::registerMenuOption('Settings', 'Themes', 'settings/themes', 'theme');
		\Monal::registerPermissionSet(
			'Themes',
			'themes',
			array(
			)
		);

		// Register Facades
		$this->app['themes'] = $this->app->share(
			function ($app) {
				return new \Monal\Themes\Libraries\Themes;
			}
		);
		$this->app->booting(
			function () {
				$loader = \Illuminate\Foundation\AliasLoader::getInstance();
				$loader->alias('Themes', 'Monal\Themes\Facades\Themes');
			}
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return	Array
	 */
	public function provides()
	{
		return array();
	}
}
