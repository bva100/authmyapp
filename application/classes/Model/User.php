<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User model
 *
 * @author BRIAN ANDERSON
 */
class Model_User extends Model_Abstract implements Interface_Model_User {
	
	/**
	 * password hash algo types
	 */
	const HASH_KOHANA_AUTH = 0;
	
	public static function create_with_email(Dao_Abstract $dao, $email)
	{
		if ($dao->loaded()) 
		{
			$dao->clear();
		}
		
		if (isset($email)) 
		{
			$valid = Valid::email($email);
			if ( ! $valid) 
			{
				throw new Exception('Invalid email address', 1);
			}
			else
			{
				$dao->email = $email;
			}
		}
		
		$dao->create_timestamp = time();
		$dao->create();
		$user = Factory_Model::create($dao);
		return($user);
	}
	
	/**
	 * Creates and returns a new Model_user given a DAO
	 *
	 * @param Dao_Abstract $dao 
	 * @return Model_User
	 * @author BRIAN ANDERSON
	 */
	public static function create(Dao_Abstract $dao)
	{
		$user = self::create_with_email($dao, NULL);
		return($user);
	}
	
	/**
	 * set email
	 *
	 * @param string $email
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_email($email, $lazy = FALSE)
	{
		$valid = Valid::email($email);
		if ( ! $valid) 
		{
			throw new Exception('Invalid email address', 1); die;
		}
		
		$this->dao->email = $email;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get email
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function email()
	{
		return($this->dao->email);
	}
	
	/**
	 * set facebook_id
	 *
	 * @param float $facebook_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_id($facebook_id, $lazy = FALSE)
	{
		if ( ! is_float($facebook_id) )
		{
			trigger_error('set_facebook_id expects argument 1 to be type float', E_USER_WARNING);
		}
		$this->dao->facebook_id = $facebook_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get facebook_id
	 *
	 * @return float
	 * @author BRIAN ANDERSON
	 */
	public function facebook_id()
	{
		return( (float) $this->dao->facebook_id);
	}
	
	/**
	 * set first_name
	 *
	 * @param string $first_name
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_first_name($first_name, $lazy = FALSE)
	{
		if ( ! is_string($first_name) )
		{
			trigger_error('set_first_name expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->first_name = $first_name;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get first_name
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function first_name()
	{
		return($this->dao->first_name);
	}
	
	/**
	 * set last_name
	 *
	 * @param string $last_name
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_last_name($last_name, $lazy = FALSE)
	{
		if ( ! is_string($last_name) )
		{
			trigger_error('set_last_name expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->last_name = $last_name;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get last_name
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function last_name()
	{
		return($this->dao->last_name);
	}
	
	/**
	 * Set password using a hash_algo object and a raw password string
	 *
	 * @param Hash_Algo_Abstract $hash_algo 
	 * @param string $raw_password 
	 * @param string $lazy 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_password(Hash_Algo_Abstract $hash_algo, $raw_password, $lazy = FALSE)
	{
		if ( ! is_string($raw_password) )
		{
			trigger_error('set_password expects argument 2, raw_password, to be type string', E_USER_WARNING);
		}
		
		// validate
		if (strlen($raw_password) < 7) 
		{
			throw new Exception('Password must be longer than 6 characters', 1);
		}
		
		// set password
		$password                      = $hash_algo->hash($raw_password);
		$this->dao->password           = $password;
		$this->dao->password_hash_type = $hash_algo->name();
		
		//update
		if ( ! $lazy) 
		{
			$this->db_update();
		}
	}
	
}
