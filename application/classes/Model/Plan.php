<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Plan Model
 *
 * @author BRIAN ANDERSON
 */
class Model_Plan extends Model_Abstract implements Interface_Model_Plan {
	
	public static function create(Dao_Abstract $dao)
	{
		if ( $dao->loaded() ) 
		{
			$dao->clear();
		}
		$dao->create_timestamp = time();
		$dao->create();
		return Factory_Model::create($dao);
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
		if ( strlen($name) < 1 OR strlen($name) > 127 ) 
		{
			throw new Exception('Invalid name. Please try again.', 1);
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
		return(ucwords($this->dao->name));
	}
	
	/**
	 * set signup_limit
	 *
	 * @param int $signup_limit
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_signup_limit($signup_limit, $lazy = FALSE)
	{
		if ( ! is_int($signup_limit) )
		{
			trigger_error('set_signup_limit expects argument 1 to be type int', E_USER_WARNING);
		}
		if ($signup_limit < 1 OR $signup_limit > 1000000) 
		{
			throw new Exception('Invalid signup limit. Please try again.', 1);
		}
		$this->dao->signup_limit = $signup_limit;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get signup_limit
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function signup_limit()
	{
		return( (int) $this->dao->signup_limit);
	}
	
	
	/**
	 * set monthly_login_limit
	 *
	 * @param int $monthly_login_limit
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_monthly_login_limit($monthly_login_limit, $lazy = FALSE)
	{
		if ( ! is_int($monthly_login_limit) )
		{
			trigger_error('set_monthly_login_limit expects argument 1 to be type int', E_USER_WARNING);
		}
		if ( $monthly_login_limit < 1 OR $monthly_login_limit > 1000000) 
		{
			throw new Exception('Invalid monthly login rate. Please try again.', 1);
		}
		$this->dao->monthly_login_limit = $monthly_login_limit;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get monthly_login_limit
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function monthly_login_limit()
	{
		return( (int) $this->dao->monthly_login_limit);
	}
	
	/**
	 * set downloads
	 *
	 * @param bool $downloads
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_downloads($downloads, $lazy = FALSE)
	{
		if ( ! is_bool($downloads) )
		{
			trigger_error('set_downloads expects argument 1 to be type bool', E_USER_WARNING);
		}
		$this->dao->downloads = (int) $downloads;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get downloads
	 *
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public function downloads()
	{
		return( (bool) $this->dao->downloads);
	}
	
	/**
	 * set price
	 *
	 * @param decimal $price
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_price($price, $lazy = FALSE)
	{
		if ( ! is_numeric($price)) 
		{
			throw new Exception('invalid decimal', 1);
		}
		$this->dao->price = $price;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get price
	 *
	 * @return decimal
	 * @author BRIAN ANDERSON
	 */
	public function price()
	{
		return($this->dao->price);
	}
	
	/**
	 * Get all plans of a given state
	 *
	 * @param Dao_Abstract $dao
	 * @param int $state consts defined in class.
	 * @return array of Model_Plan object
	 * @author BRIAN ANDERSON
	 */
	public static function all(Dao_Abstract $dao, $state = self::STATE_ACTIVE, $order = 'ASC', $limit = NULL)
	{
		if ( ! is_int($state)) 
		{
			trigger_error('Model_Plan::all() expects argument 2, state, to be string', E_USER_WARNING);
		}
		if ($dao->loaded()) 
		{
			$dao->clear();
		}
		
		$array = array();
		$plan_daos = $dao->order_by('id', $order)->limit($limit)->find_all();
		foreach ($plan_daos as $dao) 
		{
			$array[] = Factory_Model::create($dao);
		}
		return $array;
	}
	
}
