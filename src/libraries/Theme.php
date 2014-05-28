<?php
namespace Monal\Themes\Libraries;
/**
 * Theme.
 *
 * Theme library for working with the currently active theme.
 *
 * @author	Arran Jacques
 */

class Theme
{
	/**
	 * The system's settings repository. 
	 *
	 * @var		 SettingsRepository
	 */
	protected $settings_repo;

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->settings_repo = \App::make('SettingsRepository');
	}

	/**
	 * Return the name of the current theme.
	 *
	 * @return	String
	 */
	public function name()
	{
		$theme_details = include self::path() . '/theme.php';
		return $theme_details['name'];
	}

	/**
	 * Return the author of the current theme.
	 *
	 * @return	String
	 */
	public function author()
	{
		$theme_details = include self::path() . '/theme.php';
		return $theme_details['author'];
	}

	/**
	 * Return the version number of the current theme.
	 *
	 * @return	String
	 */
	public function version()
	{
		$theme_details = include self::path() . '/theme.php';
		return $theme_details['version'];
	}

	/**
	 * Return path the the current theme.
	 *
	 * @return	String
	 */
	public function path()
	{
		$theme_setting = $this->settings_repo->retrieveByKey('theme');
		return base_path() . '/themes/' . $theme_setting->value();
	}

	/**
	 * Return URL the the current theme.
	 *
	 * @param	String
	 * @return	String
	 */
	public function URL($to = null)
	{
		$theme_setting = $this->settings_repo->retrieveByKey('theme');
		return \URL::to('/themes/' . $theme_setting->value() . '/' . trim($to, '/'));
	}

	/**
	 * Return all template files for the active theme.
	 *
	 * @return	Array
	 */
	public function templates()
	{
		$templates = array();
		$theme_setting = $this->settings_repo->retrieveByKey('theme');
		$templates_dir = base_path() . '/themes/' . $theme_setting->value() . '/templates';
		foreach (scandir($templates_dir) as $dir_content) {
			if (is_file($templates_dir . '/' . $dir_content) AND substr($dir_content, -4) == '.php') {
				$filename = substr_replace($dir_content, '', -4);
				if (substr($filename, -6) == '.blade') {
					$filename = substr_replace($filename, '', -6);
				}
				$templates[$dir_content] = $filename;
			}
		}
		return $templates;
	}
}