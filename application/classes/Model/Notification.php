<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model_Notification
 *
 * @author BRIAN ANDERSON
 */
class Model_Notification extends Model_Abstract implements Interface_Model_Notification {
	
	/**
	 * Constants for types
	 */
	const TYPE_PAYMENT = 1;
	
	/**
	 * Holds an array of messenger subscribers (ie mandrill, sendgrid)
	 *
	 * @var array
	 */
	private $messengers = array();
	
	/**
	 * Create a new user
	 *
	 * @param Dao_Abstract $dao 
	 * @param Model_User $user 
	 * @param int $type 
	 * @return Model_Notification object
	 * @author BRIAN ANDERSON
	 */
	public static function create_with_user_and_type(Dao_Abstract $dao, Model_User $user, $type)
	{
		if ( ! is_int($type) ) 
		{
			trigger_error('Create_with_user_and_type expects argument 3, type, to be string', E_USER_WARNING);
		}
		if ($dao->loaded()) 
		{
			$dao->clear();
		}
		$dao->user_id = $user->id();
		$dao->type = $type;
		$dao->create_timestamp = time();
		$dao->create();
		return Factory_Model::create($dao);
	}
	
}
