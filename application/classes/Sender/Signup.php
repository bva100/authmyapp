<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Sender signup object. Used when enduser creates a new account with a client's app.
 *
 * @author BRIAN ANDERSON
 */
class Sender_Signup {
	
	/**
	 * Holds a Model_Organization object
	 *
	 * @var Model_Organization
	 */
	private $organization;
	
	/**
	 * email
	 *
	 * @var string
	 */
	private $email;
	
	/**
	 * first_name
	 *
	 * @var string
	 */
	private $first_name;
	
	/**
	 * last name
	 *
	 * @var string
	 */
	private $last_name;
	
	/**
	 * gender
	 *
	 * @var string. one char representing either 'm'ale or 'f'emale
	 */
	private $gender;
	
	/**
	 * Time user signed up for service
	 *
	 * @var unix. Unix timestamp
	 */
	private $signup_timestamp;
	
	/**
	 * IP used on signup
	 *
	 * @var string
	 */
	private $ip;
	
	/**
	 * country code
	 *
	 * @var string
	 */
	private $country_code;
	
	/**
	 * Employer name
	 *
	 * @var string
	 */
	private $employer_name;
	
	/**
	 * Job title
	 *
	 * @var string
	 */
	private $job_title;
	
	/**
	 * primary phone number
	 *
	 * @var string
	 */
	private $phone;
	
	/**
	 * facebook_id
	 *
	 * @var float
	 */
	private $facebook_id;
	
	/**
	 * facebook token
	 *
	 * @var string
	 */
	private $facebook_token;
	
	/**
	 * facebook token expires
	 *
	 * @var int. unix timestamp.
	 */
	private $facebook_token_expires;
	
	/**
	 * constructor
	 *
	 * @author BRIAN ANDERSON
	 */
	public function __construct()
	{
	}
	
	/**
	 * set email
	 *
	 * @param string $email
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_email($email)
	{
		if ( ! is_string($email) )
		{
			trigger_error('set_email expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->email = $email;
	}
	
	/**
	 * get email
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function email()
	{
		return($this->email);
	}
	
	/**
	 * set first_name
	 *
	 * @param string $first_name
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_first_name($first_name)
	{
		if ( ! is_string($first_name) )
		{
			trigger_error('set_first_name expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->first_name = $first_name;
	}
	
	/**
	 * get first_name
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function first_name()
	{
		return($this->first_name);
	}
	
	/**
	 * set last_name
	 *
	 * @param string $last_name
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_last_name($last_name)
	{
		if ( ! is_string($last_name) )
		{
			trigger_error('set_last_name expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->last_name = $last_name;
	}
	
	/**
	 * get last_name
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function last_name()
	{
		return($this->last_name);
	}
	
	/**
	 * set gender
	 *
	 * @param string $gender
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_gender($gender)
	{
		if ( ! is_string($gender) )
		{
			trigger_error('set_gender expects argument 1 to be type string', E_USER_WARNING);
		}
		if (strlen($gender) > 1)
		{
			$gender = substr($gender, 0, 1);
		}
		if ($gender !== 'm' OR $gender !== 'f') 
		{
			trigger_error('set_gender expects argument 1, gender to be either "m" or "f" ', E_USER_WARNING);
		}
		$this->gender = $gender;
	}
	
	/**
	 * get gender
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function gender()
	{
		return($this->gender);
	}
	
	/**
	 * set signup_timestamp
	 *
	 * @param int $signup_timestamp. Unix timestamp.
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_signup_timestamp($signup_timestamp)
	{
		if ( ! is_int($signup_timestamp) )
		{
			trigger_error('set_signup_timestamp expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->signup_timestamp = $signup_timestamp;
	}
	
	/**
	 * get signup_timestamp
	 *
	 * @return int. Unix timestamp.
	 * @author BRIAN ANDERSON
	 */
	public function signup_timestamp()
	{
		return( (int) $this->signup_timestamp);
	}
	
	/**
	 * set ip
	 *
	 * @param string $ip
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_ip($ip)
	{
		$valid = Valid::ip($ip);
		if ( ! $valid) 
		{
			trigger_error('set_ip expects argument 1, ip, to be a valid IP', E_USER_WARNING);
		}
		$this->ip = $ip;
	}
	
	/**
	 * get ip
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function ip()
	{
		return($this->ip);
	}
	
	/**
	 * set phone
	 *
	 * @param string $phone
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_phone($phone)
	{
		$valid = Valid::phone($phone);
		if ( ! $valid) 
		{
			trigger_error('set_phone expects argument 1, phone, to be a valid phone number', E_USER_WARNING);
		}
		$this->phone = $phone;
	}
	
	/**
	 * get phone
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function phone()
	{
		return($this->phone);
	}
	
	/**
	 * set country_code
	 *
	 * @param string $country_code
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_country_code($country_code)
	{
		if ( ! is_string($country_code) )
		{
			trigger_error('set_country_code expects argument 1 to be type string', E_USER_WARNING);
		}
		if (strlen($country_code) > 2) 
		{
			trigger_error('set_country_code expects argument 1, country_code, to be string with a length of 2', E_USER_WARNING);
		}
		$this->country_code = $country_code;
	}
	
	/**
	 * get country_code
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function country_code()
	{
		return($this->country_code);
	}
	
	/**
	 * set employer_name
	 *
	 * @param string $employer_name
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_employer_name($employer_name)
	{
		if ( ! is_string($employer_name) )
		{
			trigger_error('set_employer_name expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->employer_name = $employer_name;
	}
	
	/**
	 * get employer_name
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function employer_name()
	{
		return($this->employer_name);
	}
	
	/**
	 * set job_title
	 *
	 * @param string $job_title
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_job_title($job_title)
	{
		if ( ! is_string($job_title) )
		{
			trigger_error('set_job_title expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->job_title = $job_title;
	}
	
	/**
	 * get job_title
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function job_title()
	{
		return($this->job_title);
	}
	
	
	/**
	 * set facebook_id
	 *
	 * @param float $facebook_id
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_id($facebook_id)
	{
		$this->facebook_id = $facebook_id;
	}
	
	/**
	 * get facebook_id
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function facebook_id()
	{
		return($this->facebook_id);
	}
	
	/**
	 * set facebook_token
	 *
	 * @param string $facebook_token
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_token($facebook_token)
	{
		if ( ! is_string($facebook_token) )
		{
			trigger_error('set_facebook_token expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->facebook_token = $facebook_token;
	}
	
	/**
	 * get facebook_token
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function facebook_token()
	{
		return($this->facebook_token);
	}
	
	/**
	 * set facebook_token_expires
	 *
	 * @param string $facebook_token_expires
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_token_expires($facebook_token_expires)
	{
		if ( ! is_object($facebook_token_expires) )
		{
			trigger_error('set_facebook_token_expires expects argument 1 to be type object', E_USER_WARNING);
		}
		$this->facebook_token_expires = $facebook_token_expires;
	}
	
	/**
	 * get facebook_token_expires
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function facebook_token_expires()
	{
		return($this->facebook_token_expires);
	}
}
