<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Sender for Facebooks script
 *
 * @author BRIAN ANDERSON
 */
class Script_Sender extends Script_Abstract{
	
	public function set_file_data()
	{
		$this->file_data = '<?php

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
			self::set($k, $v);
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

/* Begin main */

// session
$sessionHelper = new SessionHelper();
$sessionHelper->secure();

// get button version
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

// get data_source
if (isset($_GET["data_source"]))
{
	switch ($_GET["data_source"]) {
		case "facebook":
		default:
			header( "Location: '.URL::base(TRUE).'connect_facebook?app_id='.$this->app->id().'&security_code=$securityCode&connect_version='.Controller_Api_Abstract::CONNECT_VERSION.'" );
			break;
	}
}';
	}
	
	/**
	 * Create Facebook Sender
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function create()
	{
		if ( ! $this->filename) 
		{
			$this->set_filename();
		}
		
		// create file
		file_put_contents ($this->path().$this->filename().'.php', $this->file_data, LOCK_EX);
		
		// set archive path. Ensure first letter is capitalized and string should begin with "/"
		$archive_path = $this->app->sender_uri();
		$archive_path = trim( $archive_path, '/' );
		$archive_path = '/'.$archive_path;
		$this->set_archive_path( $archive_path );
		
		if ( file_exists($this->path().$this->filename().'.php') ) 
		{
			// zip
			$compress = Factory_Compress::create($this->compression_type(), array($this->path().$this->filename().'.php'), $this->path().$this->filename().'.zip', $this->archive_path(), '', TRUE);
			$results = $compress->execute();
			
			// remove orig file
			unlink( $this->path().$this->filename().'.php' );
		}
		else
		{
			$results = FALSE;
		}
		
		return $results;
	}
	
	/**
	 * Text
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function text()
	{
		return $this->file_data;
	}
	
	/**
	 * Url
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function url()
	{
		// return compression url
		return $this->url_path().$this->filename().'.'.$this->compression_type();
	}
	
}
