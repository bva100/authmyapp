<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Security helper class
 *
 * @author BRIAN ANDERSON
 */
class Security {
	
	/**
	 * Dictionary of white listed IP addresses
	 *
	 * @author BRIAN ANDERSON
	 */
	public static $ip_whitelist = array(
		'local' => '192.168.2.8',
		'dev'   => '108.166.114.125',
	);
	
	/**
	 * Dictionary of white listed domains
	 *
	 * @author BRIAN ANDERSON
	 */
	public static $domain_whitelist = array(
		'local' => '192.168.2.5',
		'dev'   => 'authmyapp.com',
		'prod'  => 'authmyapp.com',
	);
	
}
