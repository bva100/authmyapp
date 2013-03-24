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

/* Begin main */

// session
$sessionHelper = new SessionHelper();
$sessionHelper->secure();

// GET vars
if ( isset($_GET["button_version"]) ) 
{
	$buttonVersion = $_GET["button_version"];
	if ( ! is_numeric($buttonVersion) ) 
	{
		$buttonVersion = 0;
	}
}
else
{
	$buttonVersion = 0;
}

// security code
$securityCode = SecurityHelper::md5_rand();
$sessionHelper->set("authMyAppSecurityToken", $securityCode);

print_r($sessionHelper->get("authMyAppSecurityToken"));

// redirect
// header( "Location: http://192.168.2.5/connect_facebook?app_id=12&security_code=$securityCode&connect_version=0.8" );