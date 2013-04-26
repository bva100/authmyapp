<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Factory for creating twitter api objects
 *
 * @author BRIAN ANDERSON
 */
class Factory_Twitter extends Factory_Abstract {
	
	/**
	 * Create a new Api_Twitter object from an injected app. Option to change default sdk as well
	 *
	 * @param Model_App $app 
	 * @param string $sdk 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function create(Model_App $app, $sdk = 'abraham', array $options = array())
	{
		$sdk = strtolower($sdk);
		
		extract($options);
		if ( ! isset($oauth_token)) 
		{
			$oauth_token = NULL;
		}
		if ( ! isset($oauth_token_secret))
		{
			$oauth_token_secret = NULL;
		}
		
		switch ($sdk) {
			case 'abraham-twitteroauth':
			case 'abraham':
				require_once APPPATH.'classes/Vendor/Abraham-twitteroauth.php';
				$sdk = new TwitterOAuth($app->twitter_key(), $app->twitter_secret(), $oauth_token, $oauth_token_secret);
				return new Api_Twitter($sdk);
				break;
			default:
				trigger_error('Factory_Twitter::create() does not recognize sdk '.$sdk, E_USER_WARNING);
				break;
		}
	}
	
}
