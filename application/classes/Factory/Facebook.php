<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH.'classes/Vendor/facebook-php-sdk/src/facebook.php';

/**
 * Create a facebook object using facebook php sdk
 *
 * @author BRIAN ANDERSON
 */
class Factory_Facebook extends Factory_Abstract {
	
	/**
	 * Create a new facebook object using php's sdk
	 *
	 * @param array $config . 'appId' and 'secret'.
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function create(array $config = NULL)
	{
		if ( ! isset($config)) 
		{
			$config = array( 'appId' => '164712480350937', 'secret' => '64d5a075f94d0a98cbd28fdc0d3ae88a' );
		}
		return new Facebook($config);
	}
	
}
