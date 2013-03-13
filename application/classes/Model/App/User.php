<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model_App_User class
 *
 * @author BRIAN ANDERSON
 */
class Model_App_User extends Model_Abstract implements Interface_Model_App_User {
	
	/**
	 * Create a new App_User object with email and app id. Returns bool TRUE if App_User already exists.
	 *
	 * @param Dao_Abstract $dao 
	 * @param string $email 
	 * @param int $app_id 
	 * @return bool | App_User object
	 * @author BRIAN ANDERSON
	 */
	public static function create_with_email_and_app_id(Dao_Abstract $dao, $email, $app_id)
	{
		if (isset($email) AND isset($app_id)) 
		{
			$pre_exists = self::exists($dao, $email, $app_id);
			if ($pre_exists)
			{
				return(TRUE);
			}
			else
			{
				$dao->clear();
			}
		}
		
		if (isset($email) AND ! Valid::email($email))
		{
			throw new Exception('Invalid email address');
		}
		if (isset($app_id) AND ! is_int($app_id)) 
		{
			trigger_error('create_with_email_and_app_id expects argument 3, app_id, to be int', E_USER_WARNING);
		}
		
		$dao->email            = $email;
		$dao->app_id           = $app_id;
		$dao->create_timestamp = time();
		$dao->create();
		return Factory_Model::create($dao);
	}
	
	/**
	 * Create a new Model_App_User
	 *
	 * @param Dao_Abstract $dao 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function create(Dao_Abstract $dao)
	{
		return self::create_with_email_and_app_id($dao, NULL, NULL);
	}
	
	/**
	 * Check if this email and app_id combination exists
	 *
	 * @param Dao_Abstract $dao 
	 * @param string $email 
	 * @param int $app_id 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function exists(Dao_Abstract $dao, $email, $app_id)
	{
		if ($dao->loaded()) 
		{
			$dao->clear();
		}
		if ( ! is_string($email))
		{
			trigger_error('exists expects argument 2, email, to be string', E_USER_WARNING);
		}
		if ( ! is_int($app_id)) 
		{
			trigger_error('exists expects argument 3, app_id, to be int', E_USER_WARNING);
		}
		
		$results = $dao->where('app_id', '=', $app_id)->and_where('email', '=', $email)->find();
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
		$this->dao->birthday = $birthday;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get birthday
	 *
	 * @return int. Unix timestamp
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
	 * set company_name
	 *
	 * @param string $company_name
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_company_name($company_name, $lazy = FALSE)
	{
		if ( ! is_string($company_name) )
		{
			trigger_error('set_company_name expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->company_name = $company_name;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get company_name
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function company_name()
	{
		return($this->dao->company_name);
	}
	
	/**
	 * set job_title
	 *
	 * @param string $job_title
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_job_title($job_title, $lazy = FALSE)
	{
		if ( ! is_string($job_title) )
		{
			trigger_error('set_job_title expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->job_title = $job_title;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get job_title
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function job_title()
	{
		return($this->dao->job_title);
	}
	
	/**
	 * set phone
	 *
	 * @param string $phone
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_phone($phone, $lazy = FALSE)
	{
		$valid = Valid::phone($phone);
		if ( ! $valid) 
		{
			throw new Exception('Invalid phone number', 1);
		}
		$this->dao->phone = $phone;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get phone
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function phone()
	{
		return($this->dao->phone);
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
	 * set gender
	 *
	 * @param string $gender
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_gender($gender, $lazy = FALSE)
	{
		if ( ! is_string($gender) AND strlen($gender) !== 1)
		{
			trigger_error('set_gender expects argument 1 to be type string and have a length of 1', E_USER_WARNING);
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
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function gender()
	{
		return($this->dao->gender);
	}
	
	/**
	 * set ip
	 *
	 * @param  $ip
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_ip($ip, $lazy = FALSE)
	{
		$valid = Valid::ip($ip);
		if ( ! $valid) 
		{
			trigger_error('set_ip expects argument 1, ip, to be a valid ip', E_USER_WARNING);
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
	
}
