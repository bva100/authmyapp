<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Interface for the Model_Organization class
 *
 * @author BRIAN ANDERSON
 */
interface Interface_Model_Organization
{
	
	public static function create(Dao_Abstract $dao);
	public static function create_with_name(Dao_Abstract $dao, $name);
	
	public static function exists(Dao_Abstract $dao, $name);
	
	public function set_name($name, $lazy = FALSE);
	public function name();
	
	public function set_url($url, $lazy = FALSE);
	public function url();
	
	public function apps();
	
} // END interface Interface_Model_Organization