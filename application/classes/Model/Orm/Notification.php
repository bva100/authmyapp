<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kohana's ORM mapping for the Notifications table
 *
 * @author BRIAN ANDERSON
 */
class Model_Orm_Notification extends ORM {
	
	/**
	 * undocumented class variable
	 *
	 * @var string
	 */
	protected $_table_name = 'notifications';
	
	/**
	 * belongs to relationships
	 *
	 * @var array
	 */
	protected $_belongs_to = array(
			'users' => array(
				'foreign_key' => 'user_id',
				'model'       => 'Orm_User',
			)
		);
}