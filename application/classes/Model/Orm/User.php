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
	 */
	protected $_table_name = 'users';
	
	/**
	 * has many relationships
	 *
	 * @var array
	 */
	protected $_has_many	= array(
			'roles' => array(
				'through'     => 'roles_users',
				'foreign_key' => 'user_id',
				'far_key'     => 'role_id',
				'model'       => 'Orm_Role',
			),
			'organizations' => array(
				'through'     => 'organizations_users',
				'foreign_key' => 'user_id',
				'far_key'     => 'organization_id',
				'model'       => 'Orm_Organization',
			)
		);
}
