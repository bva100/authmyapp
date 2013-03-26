<?php defined('SYSPATH') or die('No direct script access.');

/**
 * App_User_Login model
 *
 * @author BRIAN ANDERSON
 */
class Model_App_User_Login extends Model_Abstract implements Interface_Model_App_User_Login {
	
	/**
	 * Create a new user login
	 *
	 * @param Dao_Abstract $dao 
	 * @param Model_App_User $app_user 
	 * @return Model_App_User_Login (this)
	 * @author BRIAN ANDERSON
	 */
	public static function create(Dao_Abstract $dao, Model_App_User $app_user)
	{
		if ($dao->loaded())
		{
			$dao->clear();
		}
		$dao->app_user_id = $app_user->id();
		$dao->create_timestamp = time();
		$dao->create();
		if ($dao->id) 
		{
 			return Factory_Model::create($dao);
		}
		else
		{
			return FALSE;
		}
	}
	
}
