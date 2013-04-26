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
				return( Factory_Model::create($dao) );
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
		if (isset($app_id)) 
		{
			if ( ! is_int($app_id))
			{
				trigger_error('create_with_email_and_app_id expects argument 3, app_id, to be int', E_USER_WARNING);
			}
			if ( $app_id < 0 ) 
			{
				throw new Exception('Invalid app id. Please try again soon.', 1);
			}
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
	 * set app_id
	 *
	 * @param int $app_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_app_id($app_id, $lazy = FALSE)
	{
		if ( ! is_int($app_id) )
		{
			trigger_error('set_app_id expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->app_id = $app_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get app_id
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function app_id()
	{
		return($this->dao->app_id);
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
	 * set picture
	 *
	 * @param string $picture
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
		if ( ! Valid::url($picture)) 
		{
			throw new Exception('Invalid picture url. Please try again', 1);
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
		if ( strlen($first_name) < 0 OR strlen($first_name) > 127) 
		{
			throw new Exception('Please enter a valid first name', 1);
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
		if ( strlen($last_name) < 0 OR strlen($last_name) > 127) 
		{
			throw new Exception('Please enter a valid first name', 1);
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
		if ( $birthday < -2524500000 OR $birthday > time() ) 
		{
			throw new Exception('Invalid birthday. Please try again', 1);
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
		if ( $timezone < -24 OR $timezone > 1) 
		{
			throw new Exception('Timezone offset is invalid. Please try again.', 1);
			
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
	 * set employer_name
	 *
	 * @param string $employer_name
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_employer_name($employer_name, $lazy = FALSE)
	{
		if ( ! is_string($employer_name) )
		{
			trigger_error('set_employer_name expects argument 1 to be type string', E_USER_WARNING);
		}
		if ( strlen($employer_name) < 1 OR strlen($employer_name) > 127 ) 
		{
			throw new Exception('Invalid employer name. Please try again', 1);
		}
		$this->dao->employer_name = $employer_name;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get employer_name
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function employer_name()
	{
		return($this->dao->employer_name);
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
		if ( strlen($job_title) < 1 OR strlen($job_title) > 127 ) 
		{
			throw new Exception('Invalid employer name. Please try again', 1);
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
		if ( ! is_string($country_code) )
		{
			trigger_error('set_country_code expects argument 1 to be type string and have a length of 2', E_USER_WARNING);
		}
		if ( strlen($country_code) !== 2 ) 
		{
			throw new Exception('Invalid country code. Country code must be 2 characters. Please try again.', 1);
		}
		$this->dao->country_code = strtoupper($country_code);
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
	 * set gender
	 *
	 * @param string $gender
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_gender($gender, $lazy = FALSE)
	{
		if ( ! is_string($gender))
		{
			trigger_error('set_gender expects argument 1 to be type string and have a length of 1', E_USER_WARNING);
		}
		if ( $gender !== 'm' AND $gender !== 'f' )
		{
			throw new Exception('Invalid gender. Genders must be either M or Y. Please try again.', 1);
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
	
	/**
	 * Set facebook_id
	 *
	 * @param int| float $facebook_id 
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
	 * set linkedin_id
	 *
	 * @param string $linkedin_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_linkedin_id($linkedin_id, $lazy = FALSE)
	{
		if ( ! is_string($linkedin_id) )
		{
			trigger_error('set_linkedin_id expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->linkedin_id = $linkedin_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
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
	 * set twitter_id
	 *
	 * @param int $twitter_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_twitter_id($twitter_id, $lazy = FALSE)
	{
		if ( ! is_int($twitter_id) )
		{
			trigger_error('set_twitter_id expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->twitter_id = $twitter_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get twitter_id
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function twitter_id()
	{
		return( (int) $this->dao->twitter_id);
	}
	
	/**
	 * set twitter_username
	 *
	 * @param string $twitter_username
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_twitter_username($twitter_username, $lazy = FALSE)
	{
		if ( ! is_string($twitter_username) )
		{
			trigger_error('set_twitter_username expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->twitter_username = $twitter_username;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get twitter_username
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function twitter_username()
	{
		return($this->dao->twitter_username);
	}
	
	/**
	 * set twitter_oauth_token
	 *
	 * @param string $twitter_oauth_token
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_twitter_oauth_token($twitter_oauth_token, $lazy = FALSE)
	{
		if ( ! is_string($twitter_oauth_token) )
		{
			trigger_error('set_twitter_oauth_token expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->twitter_oauth_token = $twitter_oauth_token;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get twitter_oauth_token
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function twitter_oauth_token()
	{
		return($this->dao->twitter_oauth_token);
	}
	
	/**
	 * set twitter_oauth_token_secret
	 *
	 * @param string $twitter_oauth_token_secret
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_twitter_oauth_token_secret($twitter_oauth_token_secret, $lazy = FALSE)
	{
		if ( ! is_string($twitter_oauth_token_secret) )
		{
			trigger_error('set_twitter_oauth_token_secret expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->twitter_oauth_token_secret = $twitter_oauth_token_secret;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get twitter_oauth_token_secret
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function twitter_oauth_token_secret()
	{
		return($this->dao->twitter_oauth_token_secret);
	}
	
	
	/**
	 * Count the amount of logins given a range of unix timestamps. Pass min_timestamp and max_timestamp as null or leave empty.
	 *
	 * @param int $min_date Unix timestamp
	 * @param int $max_date Unix timestamp
	 * @param array $options 'iterate'
	 * @return mixed. If iterate returns array of int timestamps, else returns a single int timestamp
	 * @author BRIAN ANDERSON
	 */
	public function count_logins($min_timestamp, $max_timestamp, array $options = array())
	{
		if (isset($options['iterate']))
		{
			$logins_dao = $this->dao->logins;
			$array = array();
			$day_counter = 1; // base 1
			for ( $timestamp_counter = $min_timestamp; $timestamp_counter <= $max_timestamp; $timestamp_counter += 86400) 
			{
				// on this day, how many logins occured?
				$this_days_count = $logins_dao->where('create_timestamp', '>', $timestamp_counter)->and_where('create_timestamp', '<', $timestamp_counter + 86400)->count_all();
				$array[$day_counter] = $this_days_count;
				$day_counter++;
			}
			return($array);
		}
		else
		{
			$logins_dao = $this->dao->logins;
			$results = $logins_dao->where('create_timestamp', '>=', $min_timestamp)->where('create_timestamp', '<=', $max_timestamp)->count_all();
			return (int) $results;
		}
	}
	
	/**
	 * Record a login for this user
	 *
	 * @return Model_App_User_Login object
	 * @author BRIAN ANDERSON
	 */
	public function record_login(Dao_Abstract $dao)
	{
		$login = Model_App_User_Login::create($dao, $this);
		if ($login->dao->loaded()) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
}
