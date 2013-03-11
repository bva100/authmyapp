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
	 * @param Hash_Base $hash_algo
	 * @param string $raw_password 
	 * @param string $lazy 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_password(Hash_Base $hash_algo, $raw_password, $lazy = FALSE)
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
		$this->dao->password           = $hash_algo->hash($raw_password);
		$this->dao->password_hash_type = $hash_algo->name();
		
		//update
		if ( ! $lazy) 
		{
			$this->db_update();
		}
	}
	
	/**
	 * set a random password using a given hash_algo
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_rand_password(Hash_Base $hash_algo, $lazy = FALSE)
	{
		$this->dao->password           = $hash_algo->hash(mt_rand());
		$this->dao->password_hash_type = $hash_algo->name();
		
		//update
		if ( ! $lazy) 
		{
			$this->db_update();
		}
	}
	
	/**
	 * get hashed password
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function password()
	{
		return($this->dao->password);
	}
	
	/**
	 * get password_hash_type
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function password_hash_type()
	{
		return($this->dao->password_hash_type);
	}
	
	/**
	 * set facebook_id
	 *
	 * @param float $facebook_id (not forced)
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_id($facebook_id, $lazy = FALSE)
	{
		$this->dao->facebook_id = $facebook_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get facebook_id
	 *
	 * @return float (not forced)
	 * @author BRIAN ANDERSON
	 */
	public function facebook_id()
	{
		return($this->dao->facebook_id);
	}
	
	/**
	 * set facebook_token
	 *
	 * @param string $facebook_token
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_token($facebook_token, $lazy = FALSE)
	{
		if ( ! is_string($facebook_token) )
		{
			trigger_error('set_facebook_token expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->facebook_token = $facebook_token;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get facebook_token
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function facebook_token()
	{
		return($this->dao->facebook_token);
	}
	
	/**
	 * set facebook_token_created
	 *
	 * @param int $facebook_token_created. Unix timestamp.
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_token_created($timestamp, $lazy = FALSE)
	{
		if ( ! is_int($timestamp) )
		{
			trigger_error('set_facebook_token_created expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->facebook_token_created = $timestamp;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get facebook_token_created
	 *
	 * @return int. Unix timestamp
	 * @author BRIAN ANDERSON
	 */
	public function facebook_token_created()
	{
		return( (int) $this->dao->facebook_token_created);
	}
	
	/**
	 * set facebook_token_expires
	 *
	 * @param int $facebook_token_expires. Unix timestamp.
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_token_expires($timestamp, $lazy = FALSE)
	{
		if ( ! is_int($facebook_token_expires) )
		{
			trigger_error('set_facebook_token_expires expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->facebook_token_expires = $timestamp;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get facebook_token_expires
	 *
	 * @return int. Unix timestamp.
	 * @author BRIAN ANDERSON
	 */
	public function facebook_token_expires()
	{
		return( (int) $this->dao->facebook_token_expires);
	}
	
	/**
	 * get login_count
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function login_count()
	{
		return( (int) $this->dao->login_count);
	}
	
	/**
	 * get last_login
	 *
	 * @return int. Unix timestamp.
	 * @author BRIAN ANDERSON
	 */
	public function last_login()
	{
		return( (int) $this->dao->last_login);
	}
	
	/**
	 * set gender
	 *
	 * @param string $gender. "m" or "f"
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_gender($gender, $lazy = FALSE)
	{
		if ($gender !== 'm' AND $gender === 'f') 
		{
			trigger_error('set_gender expects argument 1, gender, to be string with char "m" or char "f" ', E_USER_WARNING);
		}
		
		$this->dao->gender = $gender;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get gender
	 *
	 * @return string. "m" or "f".
	 * @author BRIAN ANDERSON
	 */
	public function gender()
	{
		return($this->dao->gender);
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
	 * Add a role to this user
	 *
	 * @param string $role_name 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function add_role($role_name)
	{
		$dao_role = $this->dao->roles->clear()->where('name', '=', $role_name)->find();
		$this->dao->add('roles', $dao_role->id);
	}
	
	/**
	 * Remove a role from this user
	 *
	 * @param string $role_name 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function remove_role($role_name)
	{
		$dao_role = $this->dao->roles->clear()->where('name', '=', $role_name)->find();
		$this->dao->remove('roles', $dao_role->id);
	}
	
	/**
	 * Returns an array of role names associated with this user
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function roles()
	{
		$dao_roles = $this->dao->roles->find_all();
		$array = array();
		foreach ($dao_roles as $dao_role) 
		{
			$array[] = $dao_role->name;
		}
		return $array;
	}
	
	/**
	 * Add this user to an organization
	 *
	 * @param int $organization_id 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function add_organization($organization_id)
	{
		if ( ! is_int($organization_id)) 
		{
			trigger_error('add_organization expects argument 1, organization_id, to be int', E_USER_WARNING);
		}
		$this->dao->add('organizations', $organization_id);
	}
	
	/**
	 * Remove this user from an organization
	 *
	 * @param string $organization_id 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function remove_organization($organization_id)
	{
		if ( ! is_int($organization_id)) 
		{
			trigger_error('remove_organization expects argument 1, organization_id to be int', E_USER_WARNING);
		}
		$this->dao->remove('organizations', $organization_id);
	}
	
	/**
	 * returns an array of Model_Organization objects associated with this user
	 *
	 * @return array of Model_Organization objects
	 * @author BRIAN ANDERSON
	 */
	public function organizations()
	{
		$dao_orgs = $this->dao->organizations->find_all();
		$array = array();
		foreach ($dao_orgs as $dao_org) 
		{
			$array[] = Factory_Model::create($dao_org);
		}
		return $array;
	}
	
}
