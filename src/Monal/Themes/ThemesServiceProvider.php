<?php
namespace Monal\Themes;

use Illuminate\Support\ServiceProvider;
use Monal\MonalPackageServiceProvider;

class ThemesServiceProvider extends ServiceProvider implements MonalPackageServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var		Boolean
	 */
	protected $defer = false;

	/**
	 * Return the package's namespace.
	 *
	 * @return	String
	 */
	public function packageNamespace()
	{
		return 'monal/themes';
	}

	/**
	 * Return the package's details.
	 *
	 * @return	Array
	 */
	public function packageDetails()
	{
		return array(
			'name' => 'Themes',
			'author' => 'Arran Jacques',
			'version' => '0.9.0',
		);
	}

	/**
	 * Install the package.
	 *
	 * @return	Boolean
	 */
	public function install()
	{
		$dir_path = public_path() . '/themes';
		if (!is_dir($dir_path)) {
			mkdir($dir_path);
		}
		if (!is_dir($dir_path . '/default')) {
			mkdir($dir_path . '/default');
		}
		if (!is_dir($dir_path . '/default/templates')) {
			mkdir($dir_path . '/default/templates');
		}
		if (!is_dir($dir_path . '/default/system')) {
			mkdir($dir_path . '/default/system');
		}
		$file = fopen($dir_path . '/default/theme.php', 'w');
		fwrite($file, '<?php' . PHP_EOL);
		fwrite($file, '' . PHP_EOL);
		fwrite($file, 'return array(' . PHP_EOL);
		fwrite($file, '	\'name\' => \'Default\',' . PHP_EOL);
		fwrite($file, '	\'author\' => \'Your Name\',' . PHP_EOL);
		fwrite($file, '	\'version\' => \'0.0.0\',' . PHP_EOL);
		fwrite($file, ');' . PHP_EOL);
		fclose($file);
		$theme = \SettingsRepository::newModel();
		$theme->setKey('theme');
		$theme->setValue('default');
		\SettingsRepository::write($theme);
		return true;
	}

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
		/*
		if ($this->app['apipackages']->isInstalled('Theme')) {
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
		*/
	}

	/**
	 * Register the service provider.
	 *
	 * @return	Void
	 */
	public function register()
	{
		// Register Facades
		$this->app['themes'] = $this->app->share(function ($app) {
				return new \Monal\Themes\Libraries\Themes;
		});
		$this->app->booting(function () {
				$loader = \Illuminate\Foundation\AliasLoader::getInstance();
				$loader->alias('Themes', 'Monal\Themes\Facades\Themes');
		});

		$this->app['theme'] = $this->app->share(function ($app) {
				return new \Monal\Themes\Libraries\Theme;
		});
		$this->app->booting(function () {
				$loader = \Illuminate\Foundation\AliasLoader::getInstance();
				$loader->alias('Theme', 'Monal\Themes\Facades\Theme');
		});
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
