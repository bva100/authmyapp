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
	
	/**
	 * plan states
	 */
	const PLAN_STATE_ACTIVE       = 1;
	const PLAN_STATE_PAYMENT_HOLD = 2; // inactive at this time/failed to pay invoice
	const PLAN_STATE_OVERDUE      = 3; // plan is active but a recent invoice could not be billed due to, for example, an expires credit card
	
	/**
	 * Create a new user with email
	 *
	 * @param Dao_Abstract $dao 
	 * @param string $email 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
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
		if ( strlen($first_name) < 1 OR strlen($first_name) > 127 ) 
		{
			throw new Exception('Invalid first name. Please try again', 1);
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
		if ( strlen($last_name) < 1 OR strlen($last_name) > 127) 
		{
			throw new Exception('Invalid last name. Please try again.', 1);
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
	 * set birthday
	 *
	 * @param int $birthday. Unix timestamp.
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_birthday($birthday, $lazy = FALSE)
	{
		if ( ! is_int($birthday) )
		{
			trigger_error('set_birthday expects argument 1 to be type int', E_USER_WARNING);
		}
		if ( $birthday < -2524500000 OR $birthday > time())
		{
			throw new Exception('Invalid birthday. Please try again.', 1);
		}
		$this->dao->birthday = $birthday;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get birthday
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function birthday()
	{
		return( (int) $this->dao->birthday);
	}
	
	/**
	 * set timezone
	 *
	 * @param int $timezone. Offset.
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_timezone($timezone, $lazy = FALSE)
	{
		if ( ! is_int($timezone) )
		{
			trigger_error('set_timezone expects argument 1 to be type int', E_USER_WARNING);
		}
		if ( $timezone < -24 OR $timezone > 1) 
		{
			throw new Exception('Invalid timezone offset', 1);
		}
		$this->dao->timezone = $timezone;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get timezone
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function timezone()
	{
		return( (int) $this->dao->timezone);
	}
	
	/**
	 * set ip
	 *
	 * @param string $ip
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_ip($ip, $lazy = FALSE)
	{
		$valid = Valid::ip($ip);
		if ( ! $valid) 
		{
			throw new Exception('Invalid IP address. Please try again soon.');
		}
		$this->dao->ip = $ip;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get ip
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function ip()
	{
		return($this->dao->ip);
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
		
		//hash password
		$hashed_password = $hash_algo->hash($raw_password);
		
		// set password
		$this->dao->password           = $hashed_password;
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
	 * set picture
	 *
	 * @param string $picture URL
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_picture($picture, $lazy = FALSE)
	{
		if ( ! is_string($picture) )
		{
			trigger_error('set_picture expects argument 1 to be type string', E_USER_WARNING);
		}
		if ( ! Valid::url($picture) ) 
		{
			throw new Exception('Invalid picture. Please try again.', 1);
		}
		$this->dao->picture = $picture;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get picture
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function picture()
	{
		return($this->dao->picture);
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
		if ( strlen($facebook_token) < 5 OR strlen($facebook_token) > 255 )
		{
			throw new Exception('Invalid facebook token. Please try again', 1);
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
		if ( $timestamp < 946706400 OR $timestamp > 20000 + time() ) 
		{
			throw new Exception('Facebook token created is invalid. Please try again.', 1);
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
		if ( ! is_int($timestamp) )
		{
			trigger_error('set_facebook_token_expires expects argument 1 to be type int', E_USER_WARNING);
		}
		if ( $timestamp < time() ) 
		{
			throw new Exception('Invalid facebook token expires. Please try again', 1);
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
	 * get linkedin_id
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function linkedin_id()
	{
		return($this->dao->linkedin_id);
	}
	
	/**
	 * set linkedin_token
	 *
	 * @param string $linkedin_token
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_linkedin_token($linkedin_token, $lazy = FALSE)
	{
		if ( ! is_string($linkedin_token) )
		{
			trigger_error('set_linkedin_token expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->linkedin_token = $linkedin_token;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get linkedin_token
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function linkedin_token()
	{
		return($this->dao->linkedin_token);
	}
	
	/**
	 * set linkedin_token_created
	 *
	 * @param int $linkedin_token_created. Unix timestamp.
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_linkedin_token_created($linkedin_token_created, $lazy = FALSE)
	{
		if ( ! is_int($linkedin_token_created) )
		{
			trigger_error('set_linkedin_token_created expects argument 1 to be type int', E_USER_WARNING);
		}
		if ( $linkedin_token_created < time() ) 
		{
			throw new Exception('Invalid linkedin token created. Please try again', 1);
		}
		$this->dao->linkedin_token_created = $linkedin_token_created;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get linkedin_token_created
	 *
	 * @return int. Unix  timestamp.
	 * @author BRIAN ANDERSON
	 */
	public function linkedin_token_created()
	{
		return( (int) $this->dao->linkedin_token_created);
	}
	
	/**
	 * set linkedin_token_expires
	 *
	 * @param int $linkedin_token_expires Unix Timestamp
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_linkedin_token_expires($linkedin_token_expires, $lazy = FALSE)
	{
		if ( ! is_int($linkedin_token_expires) )
		{
			trigger_error('set_linkedin_token_expires expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->linkedin_token_expires = $linkedin_token_expires;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get linkedin_token_expires
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function linkedin_token_expires()
	{
		return( (int) $this->dao->linkedin_token_expires);
	}
	
	/**
	 * set plan_id. Automatically sets plan state to active.
	 *
	 * @param int $plan_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_plan_id($plan_id, $lazy = FALSE)
	{
		if ( ! is_int($plan_id) )
		{
			trigger_error('set_plan_id expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->plan_id = $plan_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get plan_id
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function plan_id()
	{
		return( (int) $this->dao->plan_id);
	}
	
	/**
	 * set stripe_id
	 *
	 * @param string $stripe_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_stripe_id($stripe_id, $lazy = FALSE)
	{
		if ( ! is_string($stripe_id) )
		{
			trigger_error('set_stripe_id expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->stripe_id = $stripe_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get stripe_id
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function stripe_id()
	{
		return($this->dao->stripe_id);
	}
	
	/**
	 * Get the user's current plan
	 *
	 * @return Model_Plan
	 * @author BRIAN ANDERSON
	 */
	public function plan()
	{
		$dao_plan = $this->dao->plan;
		return Factory_Model::create($dao_plan);
	}
	
	/**
	 * set plan_state
	 *
	 * @param int $plan_state
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_plan_state($plan_state, $lazy = FALSE)
	{
		if ( ! is_int($plan_state) )
		{
			trigger_error('set_plan_state expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->plan_state = $plan_state;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get plan_state
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function plan_state()
	{
		return( (int) $this->dao->plan_state);
	}
	
	/**
	 * set plan_wepay_preapproval_id
	 *
	 * @param int $plan_wepay_preapproval_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_plan_wepay_preapproval_id($plan_wepay_preapproval_id, $lazy = FALSE)
	{
		if ( ! is_int($plan_wepay_preapproval_id) )
		{
			trigger_error('set_plan_wepay_preapproval_id expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->plan_wepay_preapproval_id = $plan_wepay_preapproval_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get plan_wepay_preapproval_id
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function plan_wepay_preapproval_id()
	{
		return( (int) $this->dao->plan_wepay_preapproval_id);
	}
	
	/**
	 * set plan_wepay_preapproval_uri
	 *
	 * @param string $plan_wepay_preapproval_uri
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_plan_wepay_preapproval_uri($plan_wepay_preapproval_uri, $lazy = FALSE)
	{
		if ( ! is_string($plan_wepay_preapproval_uri) )
		{
			trigger_error('set_plan_wepay_preapproval_uri expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->plan_wepay_preapproval_uri = $plan_wepay_preapproval_uri;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get plan_wepay_preapproval_uri
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function plan_wepay_preapproval_uri()
	{
		return($this->dao->plan_wepay_preapproval_uri);
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
		if ( ! is_string($gender)) 
		{
			trigger_error('set_gender expects argument 1, gender, to be string', E_USER_WARNING);
		}
		if ($gender !== 'm' AND $gender !== 'f') 
		{
			throw new Exception('Invalid gender. Please try again', 1);
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
	 * set country_code
	 *
	 * @param string $country_code
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_country_code($country_code, $lazy = FALSE)
	{
		if ( ! is_string($country_code) OR strlen($country_code) !== 2)
		{
			trigger_error('set_country_code expects argument 1 to be type string and have a length of 2', E_USER_WARNING);
		}
		$this->dao->country_code = $country_code;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get country_code
	 *
	 * @return string. 2 char version of country.
	 * @author BRIAN ANDERSON
	 */
	public function country_code()
	{
		return($this->dao->country_code);
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
	
	/**
	 * returns an array of Model_App objects associated with this user
	 *
	 * @return array of Model_App objects
	 * @author BRIAN ANDERSON
	 */
	public function apps()
	{
		$dao_orgs = $this->dao->organizations->find_all();
		$array = array();
		foreach ($dao_orgs as $org) 
		{
			foreach ($org->apps->find_all() as $app)
			{
				$array[] = Factory_Model::create($app);
			}
		}
		return $array;
	}
	
	/**
	 * Returns an array of app_ids which are associated with this use
	 *
	 * @return array
	 * @author BRIAN ANDERSON
	 */
	public function app_ids()
	{
		$dao_orgs = $this->dao->organizations->find_all();
		$array = array();
		foreach ($dao_orgs as $org) 
		{
			foreach ($org->apps->find_all() as $app)
			{
				$array[] = (int) $app->id;
			}
		}
		return $array;
	}
	
	/**
	 * Is this user associated with the given app_id?
	 *
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public function has_app_id($app_id)
	{
		if ( ! is_int($app_id)) 
		{
			trigger_error('Has_app_id() expects argument 1, app_id, to be an int', E_USER_WARNING);
		}
		
		$app_ids = $this->app_ids();
		if ( in_array($app_id, $app_ids, TRUE) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
}
