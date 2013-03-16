<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Sender signup object. Used when app_user creates a new account with a client's app or wishes to sign in. Holds recently updated app and user objects.
 *
 * @author BRIAN ANDERSON
 */
class Sender_Signup {
	
	/**
	 * holds Model_App
	 *
	 * @var Model_App
	 */
	private $app;
	
	/**
	 * Can be app_user or user for internal purposes
	 *
	 * @var string
	 */
	private $app_user;
	
	/**
     * Type of connect used
	 *
	 * @var string
	 */
	private $method;
	
	/**
	 * access token associated with connect method
	 *
	 * @var string
	 */
	private $access_token;
	
	/**
	 * access token expiration
	 *
	 * @var int. unix timestamp.
	 */
	private $access_token_expires;
	
	/**
	 * Constructor injects Model_App and Model_User/Model_App_User objects
	 *
	 * @param Model_App $app 
	 * @param object $app_user 
	 * @author BRIAN ANDERSON
	 */
	public function __construct($method, Model_App $app, $app_user)
	{
		$this->set_app($app);
		$this->set_app_user($app_user);
		$this->set_method($method);
	}
	
	/**
	 * set app
	 *
	 * @param Model_App $app
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_app(Model_App $app)
	{
		$this->app = $app;
	}
	
	/**
	 * get app
	 *
	 * @return Model_App object
	 * @author BRIAN ANDERSON
	 */
	public function app()
	{
		return($this->dao->app);
	}
	
	/**
	 * set app_user
	 *
	 * @param object $app_user
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_app_user($app_user)
	{
		if ( ! is_object($app_user) )
		{
			trigger_error('set_app_user expects argument 1 to be type object', E_USER_WARNING);
		}
		$this->app_user = $app_user;
	}
	
	/**
	 * get app_user
	 *
	 * @return object
	 * @author BRIAN ANDERSON
	 */
	public function app_user()
	{
		return($this->app_user);
	}
	
	/**
	 * set method
	 *
	 * @param string $method.
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_method($method)
	{
		if ( ! is_string($method) )
		{
			trigger_error('set_method expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->method = $method;
	}
	
	/**
	 * get method
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function method()
	{
		return($this->method);
	}
	
	/**
	 * set access_token
	 *
	 * @param string $access_token
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_access_token($access_token)
	{
		if ( ! is_string($access_token) )
		{
			trigger_error('set_access_token expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->access_token = $access_token;
	}
	
	/**
	 * get access_token
	 *
	 * @return int. Unix timestamp.
	 * @author BRIAN ANDERSON
	 */
	public function access_token()
	{
		return($this->access_token);
	}
	
	/**
	 * set access_token_expires
	 *
	 * @param int $access_token_expires
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_access_token_expires($access_token_expires)
	{
		if ( ! is_int($access_token_expires) )
		{
			trigger_error('set_access_token_expires expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->access_token_expires = $access_token_expires;
	}
	
	/**
	 * get access_token_expires
	 *
	 * @return int. Unix timestamp.
	 * @author BRIAN ANDERSON
	 */
	public function access_token_expires()
	{
		return( (int) $this->access_token_expires);
	}
	
	
	/**
	 * generate the redirect url string for this user
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function redirect_url()
	{
		$base_url = $this->app->redirect_url();
		
		// user params. These can be more dynamic in the future
		$user_params = 'email='.urlencode($this->app_user->email()).'&first_name='.urlencode($this->app_user->first_name()).'&last_name='.urlencode($this->app_user->last_name()).'&birthday='.urlencode($this->app_user->birthday()).'&picture='.urlencode($this->app_user->picture()).'&gender='.urlencode($this->app_user->gender()).'&ip='.urlencode($this->app_user->ip()).'&employer_name='.urlencode($this->app_user->employer_name()).'&job_title='.urlencode($this->app_user->job_title()).'&country_code='.urlencode($this->app_user->country_code()).'&timezone='.urlencode($this->app_user->timezone());
		
		// security params
		$security_code = Session::instance()->get('security_code', FALSE);
		if ( ! $security_code) 
		{
			throw new Exception('Access Denied. Please Supply a valid security code.', 1);
		}
		$security_params = '&security_code='.urlencode($security_code);
		
		// method params for data associated with connect method
		$method_params = 'facebook_id='.urlencode($this->app_user->facebook_id()).'&method='.urlencode($this->method()).'&access_token='.urlencode($this->access_token()).'&token_expires='.urlencode($this->access_token_expires());
		
		return( $base_url.'?'.$user_params.'&'.$security_params.'&'.$method_params );
	}
	
	public function post()
	{
		$request = Request::factory($this->app->redirect_url());
		$response = $request->execute();
	}
	
}
