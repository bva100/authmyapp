<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Factory for all adopter classes
 *
 * @author BRIAN ANDERSON
 */
class Factory_Adopter extends Factory_Abstract {
	
	/**
	 * Create a new adopter object
	 *
	 * @param string $adopter_type 
	 * @param mixed $from 
	 * @param mixed $to 
	 * @return object
	 * @author BRIAN ANDERSON
	 */
	public static function create($adopter_type, $from, $to)
	{
		if ( ! is_string($adopter_type)) 
		{
			trigger_error('Factory_Adopter::create expects argument 1, adopter_type, to be string', E_USER_WARNING);
		}
		
		switch ($adopter_type) {
			case 'facebook_to_user':
			case 'facebook_user':
			case 'facebookUser':
				return new Adopter_FacebookUser($from, $to);
				break;
			case 'linkedin_to_user':
			case 'linkedin_user':
			case 'facebookuser';
				return new Adopter_LinkedinUser($from, $to);
			case 'appuserApi':
			case 'app_user_api':
			case 'appuser_to_api':
				return new Adopter_AppuserApi($from, $to);
				break;
			default:
				trigger_error('Factory_Adoper::create does not recognize adopter_type '.$adopter_type, E_USER_WARNING);
				break;
		}
	}
	
}
