<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Receiver Script
 *
 * @author BRIAN ANDERSON
 */
class Script_Receiver extends Script_Abstract {
	
	/**
	 * Holds file data
	 *
	 * @var string
	 */
	private $file_data;
	
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
 * Request Helper for setting GET and POST vars
 *
 * @author BRIAN ANDERSON
 */
class ParamHelper {

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
		$_GET[$key] = htmlentities($_GET[$key], ENT_QUOTES, "UTF-8");
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
		$_POST[$key] = htmlentities($_POST[$key], ENT_QUOTES, "UTF-8");
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
		$_REQUEST[$key] = htmlentities($_REQUEST[$key], ENT_QUOTES, "UTF-8");
		return($_REQUEST[$key]);
	}
}

/* Begin main */

$sessionHelper = new SessionHelper();
$sessionHelper->secure();

// hardcoded App vars. This can be changed in your apps settings on AuthMyApp.com. After changing settings, please re-download and upload the new AmaReciver.
$storage_method = "'.$this->app->storage_method().'";

// vars
$security_code = ParamHelper::get("security_code", "nada");
$data_source   = ParamHelper::get("data_source", "");
$user_id       = ParamHelper::get("user_id", 0);
$access_token  = "'.$this->app->access_token().'";

// check security code
if ( $sessionHelper->get("authMyAppSecurityToken") !== $securityCode )
{
	trigger_error("An incorrect security code has been passed. Please try again.", E_USER_WARNING);
}

// get user data via api using cURL
$headers = array("Content-Type: application/json", "Authorization: Bearer '.$this->app->access_token().'");

// create uri
$uri = "'.URL::base(TRUE).'api/users.json?user_id=".$user_id."&access_token='.urlencode($this->app->access_token()).'&v='.Controller_Api_Abstract::API_VERSION.'";

//cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, "AuthMyApp PHP SDK api_version='.Controller_Api_Abstract::API_VERSION.'");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
curl_setopt($ch, CURLOPT_URL, $uri);

// response
$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
$response = json_decode($response);

// check response for errors
if ($http_status !== 200) 
{
	// error occurred.
	echo "<pre>";
	var_dump($response);
	echo "</pre>";
	trigger_error("A $data_source error has occurred. PLease try again soon.", E_USER_WARNING);
	die();
}
if ( ! $response->email) 
{
	trigger_error("The e-mail permissions must be accepted in order to continue. Please try again and be sure to accept email permissions so we can identify you.", E_USER_WARNING);
}

// which storage method is being used?
switch ($storage_method) {
	case '.Model_App::STORAGE_MYSQL.':
		break;
	case '.Model_App::STORAGE_PHP_SESSION.':
	default:
		if (isset($response->email))
		{
			$sessionHelper->set("email", $response->email);
		}
		if (isset($response->name->first)) 
		{
			$sessionHelper->set("firstName", $response->name->first);
		}
		if (isset($response->name->last))
		{
			$sessionHelper->set("lastName", $response->name->last);
		}
		if (isset($response->birthday)) 
		{
			$sessionHelper->set("birthday", $response->birthday);
		}
		if (isset($response->facebook->picture))
		{
			$sessionHelper->set("pictureFacebook", $response->facebook->picture);
		}
		if (isset($response->gender)) 
		{
			$sessionHelper->set("gender", $response->gender);
		}
		if (isset($response->ip)) 
		{
			$sessionHelper->set("ip", $response->ip);
		}
		if (isset($response->job->employer))
		{
			$sessionHelper->set("employer", $response->job->employer);
		}
		if (isset($response->job->title)) 
		{
			$sessionHelper->set("jobTitle", $response->job->title);
		}
		if (isset($response->country_code))
		{
			$sessionHelper->set("countryCode", $response->country_code);
		}
		if (isset($response->timezone)) 
		{
			$sessionHelper->set("timezone", $response->timezone);
		}
		if (isset($response->facebook->id)) 
		{
			$sessionHelper->set("facebookId", $response->facebook->id);
		}
		if (isset($response->facebook->token))
		{
			$sessionHelper->set("facebookToken", $response->facebook->token);
		}
		if (isset($response->facebook->token_expires))
		{
			$sessionHelper->set("facebookTokenExpires", $response->facebook->token_expires);
		}
		if (isset($data_source)) 
		{
			$sessionHelper->set("dataSource", $data_source);
		}
		break;
}

//redirect to post auth url. This can be changed in '.$this->app->name().'\'s settings. Settings can be found on the AuthMyApp dashboard.
header( "Location: '.$this->app->post_auth_url().'" );';
	}
	
	public function create()
	{
		if ( ! $this->filename) 
		{
			$this->set_filename();
		}
		
		// create file
		file_put_contents ($this->path().$this->filename().'.php', $this->file_data, LOCK_EX);
		
		// set archive path. Ensure first letter is capitalized and string should begin with "/"
		$archive_path = $this->app->receiver_uri();
		$archive_path = ucfirst( trim( $archive_path, '/' ) );
		$archive_path = '/'.$archive_path;
		$this->set_archive_path( $archive_path );
		
		if ( file_exists($this->path().$this->filename().'.php') ) 
		{
			// zip
			$compress = Factory_Compress::create($this->compression_type(), array($this->path().$this->filename().'.php'), $this->path().$this->filename().'.zip', $this->archive_path(), '/Index.php', TRUE);
			$results = $compress->execute();
			
			// remove original
			unlink($this->path().$this->filename().'.php');
		}
		else
		{
			$results = FALSE;
		}
		
		// return results
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
