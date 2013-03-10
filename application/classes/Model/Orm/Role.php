<?php defined('SYSPATH') or die('No direct script access.');

class Model_Orm_Role extends ORM {
	
	/**
	 * mapped to table roles
	 *
	 * @var string
	 */
	protected $_table_name = 'roles';
	
	/**
	 * mapped has many relationships
	 *
	 * @var array
	 */
	protected $_has_many	= array(
			'users' => array(
				'through'     => 'roles_users',
				'foreign_key' => 'role_id',
				'far_key'     => 'user_id',
				'model'       => 'Orm_User',
			)
		);
}
