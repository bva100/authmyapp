<?php defined('SYSPATH') or die('No direct script access.');

/**
 * undocumented class
 *
 * @author BRIAN ANDERSON
 */
interface Interface_Model_Plan
{
	public static function create(Dao_Abstract $dao);
	
	public function set_name($name);
	public function name();
	
	public function set_signup_limit($monthly_signup_limit);
	public function signup_limit();
	
	public function set_monthly_login_limit($montly_login_limit);
	public function monthly_login_limit();
	
	public function set_downloads($downloads);
	public function downloads();
	
	public function set_price($price);
	public function price();
	
	public static function all(Dao_Abstract $dao, $state, $order, $limit);
	
} // END interface 