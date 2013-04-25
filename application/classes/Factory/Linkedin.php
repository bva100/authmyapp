<?php defined('SYSPATH') or die('No direct script access.');

/**
 * LinkedIn Factory
 *
 * @author BRIAN ANDERSON
 */
class Factory_Linkedin extends Factory_Abstract {
	
	/**
	 * Create New Linkedin SDK object from Model_App object
	 *
	 * @param Model_App $app 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function create(Model_App $app, $redirect_uri = NULL)
	{
		if ( ! isset($redirect_uri)) 
		{
			$redirect_uri = URL::base(TRUE).'connect_linkedin/getAccessToken';
		}
		if ( ! is_string($redirect_uri)) 
		{
			trigger_error('Factory_LinkedIn Create expects argument 2, redirect_uri to be string', E_USER_WARNING);
		}
		
 		$api = new Api_Linkedin($app->linkedin_key(), $app->linkedin_secret());
		$api->set_redirect_uri($redirect_uri);
		return $api;
	}
	
}
