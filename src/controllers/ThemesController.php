<?php
/**
 * Themes Controller.
 *
 * Controller for HTTP/S requests for the Themes package.
 *
 * @author	Arran Jacques
 */

use Monal\GatewayInterface;

class ThemesController extends AdminController
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
	 * @param	Monal\GatewayInterface
	 * @return	Void
	 */
	public function __construct(GatewayInterface $system_gateway, SettingsRepository $settings_repo) {
		parent::__construct($system_gateway);
		$this->settings_repo = $settings_repo;
	}

	/**
	 * Controller for HTTP/S requests for the Themes package’s settings
	 * page. Mediates requests and outputs the response.
	 *
	 * @return	Illuminate\View\View / Illuminate\Http\RedirectResponse
	 */
	public function theme()
	{
		$theme_setting = $this->settings_repo->retrieveByKey('theme');
		if ($this->input) {
			$validation = Validator::make(
				$this->input,
				array(
					'theme' => 'required'
				),
				array(
					'theme.required' => 'You need to choose a theme so that it can be saved.',
				)
			);
			if ($validation->passes()) {
				$theme_setting->setValue($this->input['theme']);
				if ($this->settings_repo->write($theme_setting)) {
					$this->system->messages->add(
						array(
							'success' => array(
								'You successfully updated the theme for you application.'
							)	
						)
					)->flash();
					return Redirect::route('admin.settings.themes');
				} else {
					$this->system->messages->add($this->settings_repo->messages()->toArray());
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