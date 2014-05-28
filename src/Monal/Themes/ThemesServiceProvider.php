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

		// Load package routes.
		$routes = __DIR__.'/../../routes.php';
		if (file_exists($routes)){
			include $routes;
		}

		// Register permissions and menu options with system.
		\Monal::registerMenuOption('Settings', 'Themes', 'settings/themes', 'theme');
		\Monal::registerPermissionSet(
			'Themes',
			'themes',
			array(
			)
		);

		// Load in any system files the theme wants to add.
		$theme = new \Monal\Themes\Libraries\Theme;
		$path = $theme->path() . '/system';
		if (file_exists($path) AND is_dir($path)) {
			$dir = new \RecursiveDirectoryIterator($path);
			foreach (new \RecursiveIteratorIterator($dir) as $filename => $file) {
				if (substr($file->getFilename(), -4) == '.php') {
					include $filename;
				}
			}
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return	Void
	 */
	public function register()
	{
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

		$this->app['theme'] = $this->app->share(
			function ($app) {
				return new \Monal\Themes\Libraries\Theme;
			}
		);
		$this->app->booting(
			function () {
				$loader = \Illuminate\Foundation\AliasLoader::getInstance();
				$loader->alias('Theme', 'Monal\Themes\Facades\Theme');
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
