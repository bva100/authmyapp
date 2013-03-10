<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana's mapping to Roles_Users
 *
 * @author BRIAN ANDERSON
 */
class Roles_Users extends ORM {
	
	/**
	 * Mapped to the roles_users table
	 *
	 * @var string
	 */
	protected $_table_name = 'roles_users';
	
	protected $_belongs_to = array(
			'users' => array(
				'foreign_key' => 'user_id',
				'model'       => 'Orm_User',
			),
			'roles' => array(
				'foreign_key' => 'role_id',
				'model'       => 'Orm_Role',
			)
		);
	
}
