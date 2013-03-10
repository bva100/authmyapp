<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Authenticate factory
 * @author BRIAN ANDERSON
 */
class Factory_Authenticate extends Factory_Abstract {
	
	/**
	 * Creates a new instance of an Authenticate class
	 *
	 * @param string | object $auth_type can be string type or auth object
	 * @return Authenticate object
	 * @author BRIAN ANDERSON
	 */
	public static function create($auth_type)
	{
		if ( ! is_string($auth_type) AND ! is_object($auth_type) ) 
		{
			trigger_error('Factory Authenticate create expects argument 1 to be string or an auth object', E_USER_WARNING);
		}
		
		// if auth type is a string, create the appropriate auth_object
		if ( is_string($auth_type) ) 
		{
			switch ($auth_type) {
				case 'kohana':
					$auth_object = Auth::instance();
					break;
				default:
					trigger_error('Factory Authenticate expects argument 1 to be enumerated type: "kohana", " ". Your passed "'.$auth_type.'"', E_USER_WARNING);
					break;
			}
		}
		else
		{
			$auth_object = $auth_type;
		}
		
		return( new Authenticate($auth_object) );
	}
	
}