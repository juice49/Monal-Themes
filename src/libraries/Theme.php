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
	 * Return all template files for the currently active theme.
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