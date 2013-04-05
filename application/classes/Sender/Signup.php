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
	private $data_source;
	
	/**
	 * Constructor injects Model_App and Model_User/Model_App_User objects
	 *
	 * @param Model_App $app 
	 * @param object $app_user 
	 * @author BRIAN ANDERSON
	 */
	public function __construct($data_source, Model_App $app, $app_user)
	{
		$this->set_app($app);
		$this->set_app_user($app_user);
		$this->set_data_source($data_source);
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
	 * set data_source
	 *
	 * @param string $data_source.
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_data_source($data_source)
	{
		if ( ! is_string($data_source) )
		{
			trigger_error('set_data_source expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->data_source = $data_source;
	}
	
	/**
	 * get data_source
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function data_source()
	{
		return($this->data_source);
	}
	
	/**
	 * generate the redirect url string for this user
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function redirect_url()
	{
		// base url
		$base_url = $this->app->receiver_url();
		// security params
		$security_code = Session::instance()->get('security_code', FALSE);
		if ( ! $security_code) 
		{
			throw new Exception('Access Denied. Please Supply a valid security code.', 1);
		}
		$security_params    = 'security_code='.urlencode($security_code);
		$data_source_params = 'data_source='.urlencode($this->data_source());
		$user_params        = 'user_id='.$this->app_user->id();
		// concatenate url with params and return
		return( $base_url.'?'.$security_params.'&'.$data_source_params.'&'.$user_params );
	}
	
}
