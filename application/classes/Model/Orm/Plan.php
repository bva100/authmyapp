<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana's ORM mapping for App table
 *
 * @author BRIAN ANDERSON
 */
class Model_Orm_Plan extends ORM {
	
	/**
	 * undocumented class variable
	 *
	 * @var string
	 */
	protected $_table_name = 'plans';
	
	/**
	 * belongs to relationships
	 *
	 * @var array
	 */
	protected $_has_many = array(
			'users' => array(
				'foreign_key' => 'plan_id',
				'model'       => 'Orm_User',
			)
		);
}