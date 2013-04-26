<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Api Twitter Decorator for twitter php sdk
 *
 * @author BRIAN ANDERSON
 */
class Api_Twitter {
	
	/**
	 * Any valid Twitter skd, pref is found at https://github.com/abraham/twitteroauth
	 *
	 * @var object
	 */
	private $sdk;
	
	/**
	 * redirect to which uri?
	 *
	 * @var string
	 */
	private $redirect_uri;
	
	/**
	 * temp creds
	 *
	 * @var object
	 */
	private $request_token;
	
	/**
	 * access token
	 *
	 * @var string
	 */
	private $access_token;
	
	/**
	 * Constructor injects a valid sk
	 *
	 * @param object $sdk 
	 * @author BRIAN ANDERSON
	 */
	public function __construct($sdk)
	{
		$this->set_sdk($sdk);
	}
	
	/**
	 * set sdk
	 *
	 * @param object $sdk
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_sdk($sdk)
	{
		if ( ! is_object($sdk) )
		{
			trigger_error('set_sdk expects argument 1 to be type object', E_USER_WARNING);
		}
		$this->sdk = $sdk;
	}
	
	/**
	 * get sdk
	 *
	 * @return object
	 * @author BRIAN ANDERSON
	 */
	public function sdk()
	{
		return($this->sdk);
	}
	
	/**
	 * set redirect_uri
	 *
	 * @param string $redirect_uri
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_redirect_uri($redirect_uri, $lazy = FALSE)
	{
		if ( ! is_string($redirect_uri) )
		{
			trigger_error('set_redirect_uri expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->redirect_uri = $redirect_uri;
		if ( ! $lazy ) 
		{
			$this->set_request_token();
		}
	}
	
	/**
	 * get redirect_uri
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function redirect_uri()
	{
		return($this->redirect_uri);
	}
	
	/**
	 * Sets request token in sdk
	 *
	 * @author BRIAN ANDERSON
	 */
	public function set_request_token()
	{
		$this->request_token = $this->sdk->getRequestToken( $this->redirect_uri );
	}
	
	/**
	 * Get auth uri
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function auth_uri($twitter_signin = TRUE)
	{
		return $this->sdk->getAuthorizeURL($this->request_token);
	}
	
	/**
	 * Set access token
	 *
	 * @param string $oauth_verifier 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_access_token($oauth_verifier)
	{
		$this->access_token = $this->sdk->getAccessToken($oauth_verifier);
	}
	
	/**
	 * get access_token
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function access_token()
	{
		return($this->access_token);
	}
	
}
