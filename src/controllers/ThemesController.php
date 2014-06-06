<?php
/**
 * Themes Controller.
 *
 * Controller for HTTP/S requests for the Themes pacakge's admin
 * pages.
 *
 * @author	Arran Jacques
 */

use Monal\GatewayInterface;

class ThemesController extends AdminController
{
	/**
	 * Controller for HTTP/S requests for the Themes page of the Themes
	 * package. Mediates the requests and outputs a response.
	 *
	 * @return	Illuminate\View\View / Illuminate\Http\RedirectResponse
	 */
	public function theme()
	{
		if (!$theme_setting = SettingsRepository::retrieveByKey('theme')) {
			$theme_setting = SettingsRepository::newModel();
		}
		if ($this->input) {
			$validation = Validator::make(
				$this->input,
				array(
					'theme' => 'required'
				),
				array(
					'theme.required' => 'You need to choose a theme for your application.',
				)
			);
			if ($validation->passes()) {
				$theme_setting->setValue($this->input['theme']);
				if (SettingsRepository::write($theme_setting)) {
					$this->system->messages->add(
						array(
							'success' => array(
								'You successfully updated the theme for you application.'
							)	
						)
					)->flash();
					return Redirect::route('admin.settings.themes');
				} else {
					$this->system->messages->add(SettingsRepository::messages()->toArray());
				}
			} else {
				$this->system->messages->add($validation->messages()->toArray());
			}
		}
		$themes = array();
		foreach (Themes::available() as $dir_name => $theme_details) {
			$themes[$dir_name] = $theme_details['name'];
		}
		$messages = $this->system->messages->get();
		return View::make('themes::themes', compact('messages', 'themes', 'theme_setting'));
	}
}