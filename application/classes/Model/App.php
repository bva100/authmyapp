<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model_App class
 *
 * @author BRIAN ANDERSON
 */
class Model_App extends Model_Abstract implements Interface_Model_App {
	
	/**
	 * Creates a new App with name and organization. If app name and org_id combo already exists, returns false. Otherwise returns Model_App object.
	 *
	 * @param Dao_Abstract $dao 
	 * @param string $name 
	 * @param int $organization_id 
	 * @return bool | Model_App object
	 * @author BRIAN ANDERSON
	 */
	public static function create_with_name_and_organization_id(Dao_Abstract $dao, $name, $organization_id)
	{
		// check for pre-existing app
		$pre_existing = self::exists($dao, $name, $organization_id);
		if ($pre_existing) 
		{
			return(TRUE);
		}
		else
		{
			$dao->clear();
		}
		
		if (isset($name))
		{
			if ( ! is_string($name) )
			{
				trigger_error('create_with_name_and_organization_id expects argument 2, name, to be string', E_USER_WARNING);
			}
			else
			{
				$dao->name = str_replace(' ', '_', $name);
			}
		}
		if (isset($organization_id))
		{
			if ( ! is_int($organization_id) )
			{
				trigger_error('create_with_name_and_organization_id expects argument 3, organization_id, to be int', E_USER_WARNING);	
			}
			else
			{
				$dao->organization_id = $organization_id;
			}
		}
		$dao->create_timestamp = time();
		$dao->create();
		return Factory_Model::create($dao);
	}
	
	/**
	 * Creates a new Model_App object. Returns bool true if app already exists and Model_App on success.
	 *
	 * @param Dao_Abstract $dao 
	 * @return bool | Model_App object
	 * @author BRIAN ANDERSON
	 */
	public static function create(Dao_Abstract $dao)
	{
		return self::create_with_name_and_organization_id($dao, NULL, NULL);
	}
	
	public static function exists(Dao_Abstract $dao, $name, $organization_id)
	{
		if ($dao->loaded()) 
		{
			$dao->clear();
		}
		if ( ! is_string($name)) 
		{
			trigger_error('exists expects argument 2 , name, to be a string', E_USER_WARNING);
		}
		if ( ! is_int($organization_id)) 
		{
			trigger_error('exists expects argument 3, organization_id, to be int', E_USER_WARNING);
		}
		
		$name = str_replace(' ', '_', $name);
		
		$results = $dao->where('organization_id', '=', $organization_id)->and_where('name', '=', $name)->find();
		if ($results->loaded()) 
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
	 * set organization_id
	 *
	 * @param int $organization_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_organization_id($organization_id, $lazy = FALSE)
	{
		if ( ! is_int($organization_id) )
		{
			trigger_error('set_organization_id expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->organization_id = $organization_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get organizaton_id
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function organization_id()
	{
		return( (int) $this->dao->organization_id);
	}
}
