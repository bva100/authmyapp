<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A decorator for a selected auth module
 *
 * @author BRIAN ANDERSON
 */
class Authenticate {
	
	/**
	 * holds an auth object
	 *
	 * @var object
	 */
	private $auth_object;
	
	/**
	 * Constructor. Inject an auth object.
	 *
	 * @param object $auth_object 
	 * @author BRIAN ANDERSON
	 */
	public function __construct($auth_object)
	{
		$this->set_auth_object($auth_object);
	}
	
	/**
	 * set auth_object
	 *
	 * @param object $auth_object
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_auth_object($auth_object)
	{
		if ( ! is_object($auth_object) )
		{
			trigger_error('set_auth_object expects argument 1 to be type object', E_USER_WARNING);
		}
		$this->auth_object = $auth_object;
	}
	
	/**
	 * get auth_object
	 *
	 * @return object
	 * @author BRIAN ANDERSON
	 */
	public function auth_object()
	{
		return($this->auth_object);
	}
	
	/**
	 * Attempts to log a user in
	 *
	 * @param string $email
	 * @param string $password 
	 * @param bool $remember. Not yet implemented.
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public function login($email, $password, $remember = FALSE)
	{
		if ( ! is_string($email) ) 
		{
			trigger_error('login expects argument 1 to be string', E_USER_WARNING);
		}
		if ( ! is_string($password) ) 
		{
			trigger_error('login expects argument 2 to be string', E_USER_WARNING);
		}
		if ( ! is_bool($remember) ) 
		{
			trigger_error('login expects argument 3 to be bool', E_USER_WARNING);
		}
		
		$result = $this->auth_object->login($email, $password, $remember);
		if ($result) 
		{
			$this->record_login();
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
	}
	
	/**
	 * Forces a user login without a password
	 *
	 * @param string $email 
	 * @return object | bool . Returns a db_user object on success and bool FALSE if failed
	 * @author BRIAN ANDERSON
	 */
	public function force_login($email)
	{
		$result = $this->auth_object->force_login($email);
		if ($result) 
		{
			$this->record_login();
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
	}
	
	/**
	 * Records login into database. Uses db_object associated with auth_object.
	 *
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	private function record_login()
	{
		// get user
		$user = $this->get_user();
		if ( ! $user) 
		{
			return(FALSE);
		}
		
		$user->login_count = ++$user->login_count;
		$user->last_login = time();
		$user->update();
		return(TRUE);
	}
	
	/**
	 * Logout the currently logged in user
	 *
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public function logout()
	{
		$success = $this->auth_object->logout();
		if ($success) 
		{
			// ensure entire session is unset
			session_unset();
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
	}
	
	/**
	 * Checks if a session is active. If role param is passed, checks to ensure current session has this role.
	 *
	 * @param string | array. Role name string or an array with role names.
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public function logged_in($role = NULL)
	{
		$result = $this->auth_object->logged_in($role);
		if ($result) 
		{
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
	}
	
	/**
	 * Get the currently logged in user
	 *
	 * @return mixed. On Success returns a DAO user object, on failure returns false
	 * @author BRIAN ANDERSON
	 */
	public function get_user()
	{
		$db_user = $this->auth_object->get_user();
		if ($db_user) 
		{
			return($db_user);
		}
		else
		{
			return(FALSE);
		}
	}
	
}
