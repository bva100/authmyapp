<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Mongo Helper Class
 *
 * @author BRIAN ANDERSON
 */
class MongoHelper {
	
	/**
	 * Return a new MongoId object
	 *
	 * @param string | int $id 
	 * @return MongoId object
	 * @author BRIAN ANDERSON
	 */
	public static function id($id)
	{
		return new MongoId($id);
	}
	
	/**
	 * Helper for finding by given mongo id
	 *
	 * @param string | int | object $id 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function findId($id)
	{
		if (is_object($id)) 
		{
			return array( '_id' => $id );
		}
		else
		{
			return array( '_id' => self::id($id) );
		}
	}
	
	/**
	 * Helper for creating set query
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function set(array $query)
	{
		return array( '$set' => $query );
	}
	
}
