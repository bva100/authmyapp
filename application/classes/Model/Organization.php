<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model_Organization class
 *
 * @author BRIAN ANDERSON
 */
class Model_Organization extends Model_Abstract implements Interface_Model_Organization {
	
	/**
	 * Create a new organization. If organization already exists, returns bool true. Otherwise returns Model_Organization object.
	 *
	 * @param Dao_Abstract $dao 
	 * @param string $name 
	 * @return Model_Organization | bool
	 * @author BRIAN ANDERSON
	 */
	public static function create_with_name(Dao_Abstract $dao, $name)
	{
		if (isset($name) AND ! is_string($name)) 
		{
			trigger_error('create_with_name expects argument 2, name, to be string', E_USER_WARNING);
		}
		
		if ($dao->loaded()) 
		{
			$dao->clear();
		}
		
		// does this name already exist in db?
		if (isset($name)) 
		{
			$exists = self::exists($dao, $name);
			if ($exists) 
			{
				return(Factory_Model::create($dao));
			}
			else
			{
				$dao->clear();
			}
			$name = str_replace(' ', '_', $name);
			if ( strlen($name) > 127 OR strlen($name) < 0 ) 
			{
				throw new Exception('Invalid name. Please try again.', 1);
			}
			$dao->name = $name;
		}
		
		$dao->create_timestamp = time();
		$dao->create();
		return Factory_Model::create($dao);
	}
	
	/**
	 * Creates a new organization. If organization already exists, returns bool true. otherwise returns Model_Organization object.
	 *
	 * @param Dao_Abstract $dao 
	 * @return Model_Organization | bool
	 * @author BRIAN ANDERSON
	 */
	public static function create(Dao_Abstract $dao)
	{
		return self::create_with_name($dao, NULL);
	}
	
	/**
	 * Does this organization already exist?
	 *
	 * @param string $name 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public static function exists(Dao_Abstract $dao, $name)
	{
		if ( ! is_string($name)) 
		{
			trigger_error('exists expects argument 2, name, to be string', E_USER_WARNING);
		}
		if ($dao->loaded()) 
		{
			$dao->clear();
		}
		
		$name = str_replace(' ', '_', $name);
		
		$result = $dao->where('name', '=', $name)->find();
		if ($result->loaded()) 
		{
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
		
	}
	
	/**
	 * set name
	 *
	 * @param string $name
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_name($name, $lazy = FALSE)
	{
		if ( ! is_string($name) )
		{
			trigger_error('set_name expects argument 1 to be type string', E_USER_WARNING);
		}
		if ( strlen($name) < 1 OR strlen($name) > 127) 
		{
			throw new Exception('Name invalid. Please try again.', 1);
		}
		// format
		$name = str_replace(' ', '_', $name);
		$this->dao->name = $name;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get name
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function name()
	{
		return(ucwords(str_replace('_', ' ', $this->dao->name)));
	}
	
	/**
	 * set url
	 *
	 * @param string $url
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_url($url, $lazy = FALSE)
	{
		$valid = Valid::url($url);
		if ( ! $valid) 
		{
			throw new Exception('Url is not valid', 1);
		}
		$this->dao->url = $url;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get url
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function url()
	{
		return($this->dao->url);
	}
	
}
