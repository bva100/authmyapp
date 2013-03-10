<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana's ORM mapping for App table
 *
 * @author BRIAN ANDERSON
 */
class Model_Orm_App extends ORM {
	
	/**
	 * undocumented class variable
	 *
	 * @var string
	 */
	protected $_table_name = 'apps';
	
	/**
	 * has many relationships
	 *
	 * @var array
	 */
	protected $_has_many	= array(
			'app_users' => array(
				'foreign_key' => 'app_id',
				'model'       => 'Orm_App_User',
			)
		);
	
	/**
	 * belongs to relationships
	 *
	 * @var array
	 */
	protected $_belongs_to = array(
			'organizations' => array(
				'foreign_key' => 'organization_id',
				'model'       => 'Orm_Organization',
			)
		);
}
