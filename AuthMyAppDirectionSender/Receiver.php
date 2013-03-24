<?php

/**
 * SessionHelper for managing sessions
 *
 * @author AuthMyApp
 */
class SessionHelper {

	/**
	 * Starts session. Use lazy loading to account for environments which use auto sessions
	 *
	 * @author BRIAN ANDERSON
	 */
	public function __construct()
	{
		if ( ! session_id() ) 
		{
			session_start();
		}
	}

	/**
	 * Convenience method. Call regenerate method and, in the future, might call a fingerprint method.
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function secure()
	{
		$this->regenerate();
		// $this->fingerprint();
	}

	/**
	 * Regenerate session id, if needed. This method helps fight fixation attacks.
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function regenerate()
	{
		if ( ! isset($_SESSION["initiated"]) )
		{
			session_regenerate_id();
			$_SESSION["initiated"] = TRUE;
		}
	}

	/**
	 * Setter
	 *
	 * @param string $key 
	 * @param mixed $value 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	
	/**
	 * Set more than one session variable in one call
	 *
	 * @param array $array 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function massSet(array $array)
	{
		foreach ($array as $k => $v) 
		{
			$this->set($k, $v);
		}
	}

	/**
	 * Getter
	 *
	 * @param string $key 
	 * @param mixed $default 
	 * @return mixed
	 * @author BRIAN ANDERSON
	 */
	public function get($key, $default = NULL)
	{
		if ( isset($_SESSION[$key]) ) 
		{
			return($_SESSION[$key]);
		}
		else
		{
			return($default);
		}
	}

	/**
	 * Delete a session variable
	 *
	 * @param string $key 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public function delete($key)
	{
		if ( isset($_SESSION[$key]) ) 
		{
			unset($_SESSION[$key]);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

/**
 * SecurityHelper for generating salts, hashing strings, and encrypting data
 *
 * @author BRIAN ANDERSON
 */
class SecurityHelper {

	/**
	 * Creates a random salt using mt_rand, uniqid with more entropy and md5 hash
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function md5_rand()
	{
		return md5(uniqid(mt_rand(), TRUE));
	}
}

/**
 * Request Helper for setting GET and POST vars
 *
 * @author BRIAN ANDERSON
 */
class RequestHelper {
	
	/**
	 * safely set GET vars
	 *
	 * @param string $key 
	 * @param string $default 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function get($key, $default = NULL)
	{
		if ( ! isset($_GET[$key]) OR ! $_GET[$key] ) 
		{
			return $default;
		}
		$_GET[$key] = htmlentities($_GET[$key], ENT_QUOTES, 'UTF-8');
		return($_GET[$key]);
	}
	
	/**
	 * Safely set POST vars
	 *
	 * @param string $key 
	 * @param mixed $default 
	 * @return mixed
	 * @author BRIAN ANDERSON
	 */
	public static function post($key, $default = NULL)
	{
		if ( ! isset($_POST[$key]) OR ! $_POST[$key] ) 
		{
			return $default;
		}
		$_POST[$key] = htmlentities($_POST[$key], ENT_QUOTES, 'UTF-8');
		return($_POST[$key]);
	}
	
	/**
	 * Set request vars for post, get or cookie. Avoid using if method is known prior to call.
	 *
	 * @param string $key 
	 * @param mixed $default 
	 * @return mixed
	 * @author BRIAN ANDERSON
	 */
	public static function request($key, $default = NULL)
	{
		if ( ! isset($_REQUEST[$key]) OR ! $_REQUEST[$key] )
		{
			return $default;
		}
		$_REQUEST[$key] = htmlentities($_REQUEST[$key], ENT_QUOTES, 'UTF-8');
		return($_REQUEST[$key]);
	}
	
}


/**
 * ValidateHelper
 *
 * @author BRIAN ANDERSON
 */
class Validate {
	
	/**
	 * check email
	 *
	 * @param string $email 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public static function email($email)
	{
		if ( ! filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/**
	 * Check urk
	 *
	 * @param string $url 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public static function url($url)
	{
		if ( ! filter_var($url, FILTER_VALIDATE_URL)) 
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/**
	 * check name
	 *
	 * @param string $name 
	 * @param int $max_length 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public static function name($name, $maxLength = 63)
	{
		if ( ! is_string($name)) 
		{
			return FALSE;
		}
		else if ( strlen($name) < 1 OR strlen($name) > $maxLength )
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/**
	 * check ip
	 *
	 * @param string $ip 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public static function ip($ip)
	{
		if ( ! filter_var($ip, FILTER_VALIDATE_IP))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/**
	 * Validates a birthday. Only works with unix timestamps.
	 *
	 * @param int $birthday 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public static function birthday($birthday)
	{
		if ( ! is_int($birthday)) 
		{
			return FALSE;
		}
		else if ($birthday < -2524521600 OR $birthday > time() ) 
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/**
	 * check gender
	 *
	 * @param string $gender 
	 * @param bool $abbr 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public static function gender($gender, $abbr = TRUE)
	{
		if ($abbr) 
		{
			if ($gender === "m" OR $gender === "f") 
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			if ($gender !== "male" OR $gender !== "female") 
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
	}
	
	/**
	 * Check country code
	 *
	 * @param string $countryCode 
	 * @param int $length 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public static function countryCode($countryCode, $length = 2)
	{
		if ( ! is_string($countryCode)) 
		{
			return FALSE;
		}
		else if ( strlen($countryCode) > $length ) 
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public static function timezoneOffset($timezoneOffset)
	{
		if ( ! is_numeric($timezoneOffset)) 
		{
			return FALSE;
		}
		else if ($timezoneOffset < -24 OR $timezoneOffset > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public static function invalidMsg()
	{
		return '<br /><br /><center><h1>Your request cannot be completed at this time. <br /> Please try again soon. <a href="">Click Here to Return.</a></h1></center>';
	}
	
	
}


/* Begin main */

$sessionHelper = new SessionHelper();
$sessionHelper->secure();

// hardcoded App vars. This can be changed in your apps settings on AuthMyApp.com. After changings settings please re-install this file onto your server.
$storage_method = ".$app->storage_method().";
$delivery_method = ".$app->delivery_method().";

if ($delivery_method === "'.Model_App::DELIVERY_GET_ENCRYPTED.'")
{
	// working with encrypted GET string
	
}
else
{
	// working with GET
	$email         = RequestHelper::request("email");
	$firstName     = RequestHelper::request("first_name");
	$lastName      = RequestHelper::request("last_name");
	$birthday      = (int) RequestHelper::request("birthday");
	$picture       = RequestHelper::request("picture");
	$gender        = RequestHelper::request("gender");
	$ip            = RequestHelper::request("ip");
	$employerName  = RequestHelper::request("employer_name");
	$jobTitle      = RequestHelper::request("job_title");
	$countryCode   = RequestHelper::request("country_code");
	$timezone      = (int) RequestHelper::request("timezone");
	$facebookId    = RequestHelper::request("facebook_id");
	$method        = RequestHelper::request("method"); // source of data
	$accessToken   = RequestHelper::request("access_token");
	$tokenExpires  = (int) RequestHelper::request("tokenExpires");
	$securityCode  = RequestHelper::request("security_code");
}

// check security code
if ( $sessionHelper->get("authMyAppSecurityToken") !== $securityCode )
{
	trigger_error("An incorrect security code has been passed. Please try again.", E_USER_WARNING);
}

// validate data
if ( ! Validate::email($email) )
{
	trigger_error("An incorrect email has been passed. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( isset($firstName) AND ! Validate::name($firstName) )
{
	trigger_error("An incorrect first name has been passed. Please try again", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( isset($lastName) AND ! Validate::name($lastName) ) 
{
	trigger_error("An incorrect last name has been passed. Please try again", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( $birthday AND ! Validate::birthday($birthday) ) 
{
	trigger_error("an incorrect birthday has been passed. Please try again", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( isset($picture) AND ! Validate::url($picture) ) 
{
	trigger_error("an incorrect picture url has been passed. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( isset($gender) AND ! Validate::gender($gender, TRUE) ) 
{
	trigger_error("an incorrect gender has been passed. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( ! Validate::ip($ip) )
{
	trigger_error("an incorrect IP has been passed. Please try again", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if( isset($employerName) AND ! Validate::name($employerName, 127) )
{
	trigger_error("an incorrect employer name has been passed. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( isset($jobTitle) AND ! Validate::name($jobTitle, 127) )
{
	trigger_error("an incorrect job title has been passed expects. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( isset($countryCode) AND ! Validate::countryCode($countryCode, 2) ) 
{
	trigger_error("An incorrect country code was passed. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( $timezone AND ! Validate::timezoneOffset($timezone) ) 
{
	trigger_error("An incorrect timezone was passed. please try again expects.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( isset($facebookId) AND ( ! strlen($facebookId) > 200 OR strlen($facebookId) < 1) ) 
{
	trigger_error("An incorrect facebook id was passed. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( ! Validate::name($method, 127) ) 
{
	trigger_error("An incorrect method name was passed. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( isset($accessToken) AND ( strlen($accessToken) > 256 OR strlen($accessToken) < 1) )
{
	trigger_error("An incorrect access token was passed. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}
if ( $tokenExpires AND ( $tokenExpires > 20000000 OR $tokenExpires < 1)) 
{
	
	trigger_error("An incorrect access token has been passed. Please try again.", E_USER_WARNING);
	die(Validate::invalidMsg());
}

// which storage method is being used?
switch ($storage_method) {
	case "'.Model_App::STORAGE_MYSQL.'":
		die('setup mysql integration here');
		break;
	case "'.Model_App::STORAGE_PHP_SESSION.'":
	default:
		
		$sessionHelper->massSet(array(
			"email"          => $email,
			"firstName"      => $firstName,
			"lastName"       => $lastName,
			"birthday"       => $birthday,
			"picture"        => $picture,
			"gender"         => $gender,
			"ip"             => $ip,
			"employerName"   => $employerName,
			"jobTitle"       => $jobTitle,
			"countryCode"    => $countryCode,
			"timezoneOffset" => $timezone,
			"facebookId"     => $facebookId,
			"method"         => $method,
		));
		break;
}

//redirect
header( "Location: '.$this->app->post_auth_url().'" );


