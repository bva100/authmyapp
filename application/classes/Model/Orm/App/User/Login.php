<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana's ORM map to App_Users table
 *
 * @author BRIAN ANDERSON
 */
class Model_Orm_App_User_Login extends ORM {
	
	/**
	 * mapped to the app_users table
	 *
	 * @var string
	 */
	protected $_table_name = 'app_user_logins';
	
	/**
	 * belongs to relationship
	 *
	 * @var array
	 */
	protected $_belongs_to = array(
			'app_user' => array(
				'foreign_key' => 'app_user_id',
				'model'       => 'Orm_App_User',
			)
		);
}
