<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Interface for App_User_Login model
 *
 * @author BRIAN ANDERSON
 */
interface Interface_Model_App_User_Login
{
	public static function create(Dao_Abstract $dao, Model_App_User $app_user);
} // END interface 