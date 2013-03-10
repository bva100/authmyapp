<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana Organization mapping
 *
 * @author BRIAN ANDERSON
 */
class Model_Orm_Organization extends ORM {
	
	/**
	 * maps to table organizations
	 *
	 * @var string
	 */
	protected $_table_name = 'organizations';
	
	/**
	 * has many relationships
	 *
	 * @var array
	 */
	protected $_has_many  = array(
			'users' => array(
				'through'     => 'organizations_users',
				'foreign_key' => 'organization_id',
				'far_key'     => 'user_id',
				'model'       => 'Orm_User',
			),
			'apps' => array(
				'foreign_key' => 'organization_id',
				'model'       => 'Orm_App',
			)
		);
}
