<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Factory for Sender class
 *
 * @author BRIAN ANDERSON
 */
class Factory_Sender extends Factory_Abstract {
	
	public static function create($type, $method, Model_App $app, $user)
	{
		if ( ! is_string($type)) 
		{
			trigger_error('Factory_Sender::create expects argument 1, type, to be string', E_USER_WARNING);
		}
		if ( ! is_string($method)) 
		{
			trigger_error('Factory_Sender::create expects argument 2, method, to be a string', E_USER_WARNING);
		}
		if ( ! is_object($app)) 
		{
			trigger_error('Factory_Sender::create expects argument 4, user, to ab a Model_User object or a Model_App_User object', E_USER_WARNING);
		}
		
		switch ($type) {
			case 'signup':
				return new Sender_Signup($method, $app, $user);
				break;
			default:
				trigger_error('Factory_Sender does not recognize type '.$type, E_USER_WARNING);
				break;
		}
		
	}
	
}
