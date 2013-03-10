<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Factory for createing database access objects
 *
 * @author BRIAN ANDERSON
 */
class Factory_Dao extends Factory_Abstract
{
	/**
	 * Create a DAO, database access object
	 *
	 * @param string $type 
	 * @param string $table 
	 * @param int $id 
	 * @return DAO
	 * @author BRIAN ANDERSON
	 */
	public static function create($type, $table, $id = NULL)
	{
		if ( ! is_string($type) ) 
		{
			trigger_error('Factory_Dao::create expects argument 1, type, to be string', E_USER_WARNING);
		}
		if ( ! is_string($table) ) 
		{
			trigger_error('Factory_Dao::create expects argument 2, table, to be string', E_USER_WARNING);
		}
		if ( isset($id) AND ! is_int($id)) 
		{
			trigger_error('Factory_Dao::create expects argument 3, id, to be an int', E_USER_WARNING);
		}
		
		switch ($type) {
			case 'kohana':
				// convert table string to Kohana ORM format
				$table = str_replace('_', ' ', $table);
				$table = ucwords($table);
				$table = str_replace(' ', '_', $table);
				// create db_object
				$table = 'Orm_'.$table;
				$dao = ORM::factory($table, $id);
				break;
			default:
				trigger_error('create expects argument 1, dao_type to be "kohana", "" ', E_USER_WARNING);
				break;
		}
		
		return($dao);
	}
}