<?php
namespace Monal\Themes\Libraries;
/**
 * Themes.
 *
 * @author	Arran Jacques
 */

class Themes
{
	/**
	 * Return all available themes.
	 *
	 * @return	Array
	 */
	public function available()
	{
		$theme_path = base_path() . '/themes';
		$themes = array();
		foreach(scandir($theme_path) as $dir_content) {
			if (is_dir($theme_path . '/' . $dir_content) AND $dir_content != '.' AND $dir_content != '..') {
				if (file_exists($theme_path . '/' . $dir_content . '/theme.php')) {
					$themes[$dir_content] = require $theme_path . '/' . $dir_content . '/theme.php';
				}
			}
		}
		return $themes;
	}
}