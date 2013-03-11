<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana's ORM mapped Organizations_Users
 *
 * @author BRIAN ANDERSON
 */
class Model_Orm_Organization_Users extends ORM {
	
	/**
	 * mapped to the organizations_users table
	 *
	 * @var string
	 */
	protected $_table_name;
	
	/**
	 * belongs to users and organizations
	 *
	 * @var array
	 */
	protected $_belongs_to = array(
		'users' => array(
			'foreign_key' => 'user_id',
			'model'       => 'Orm_User',
		),
		'organizations' => array(
			'foreign_key' => 'organization_id',
			'model'       => 'Orm_Organization',
		),
	);
	
}
