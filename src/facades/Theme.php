<?php
namespace Monal\Themes\Facades;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return	String
	 */
	protected static function getFacadeAccessor() { return 'theme'; }
}