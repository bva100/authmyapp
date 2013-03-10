<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana ORM User
 *
 * @author BRIAN ANDERSON
 */
class Model_Orm_User extends Model_Auth_User {
	
	/**
	 * Table name
	 *
	 * @var string
	 * @author BRIAN ANDERSON
	 */
	protected $_table_name = 'users';
	
}
