<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model_App interface
 *
 * @author BRIAN ANDERSON
 */
interface Interface_Model_App
{
	public static function create_with_name_and_organization_id(Dao_Abstract $dao, $name, $organization_id);
	public static function create(Dao_Abstract $dao);
	
	public static function exists(Dao_Abstract $dao, $name, $organization_id);
	
	public function set_name($name);
	public function name();
	
	public function set_organization_id($organization_id);
	public function organization_id();
	
} // END interface Interface_Model_App