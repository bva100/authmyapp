<?php defined('SYSPATH') or die('No direct script access.');

/**
 * API LinkedIn
 *
 * @author BRIAN ANDERSON
 */
class Api_LinkedIn {
	
	const PROD_KEY    = 'uf8g2bb30r19';
	const PROD_SECRET = 'KVmVtrZXliSQ0d8k';
	
	const DEV_KEY     = 'uf8g2bb30r19';
	const DEV_SECRET  = 'KVmVtrZXliSQ0d8k';
	
	const OAUTH2_ROOT = 'https://www.linkedin.com/uas/oauth2/';
	const API_ROOT    = 'https://api.linkedin.com/';
	const VERSION     = 'v1';
	
	/**
	 * In use key
	 *
	 * @var string
	 */
	private $key;
	
	/**
	 * In user secret
	 *
	 * @var string
	 */
	private $secret;
	
	/**
	 * uri to redirect user to, after authenticating
	 *
	 * @var string
	 */
	private $redirect_uri;
	
	/**
	 * Access token
	 *
	 * @var string
	 */
	private $access_token;
	
	/**
	 * profile data
	 *
	 * @var stdObject
	 */
	private $profile;
	
	/**
	 * Constructor sets app's key and secret
	 *
	 * @param string $key if null use AuthMyApp key
	 * @param string $secret  if null use AuthMyApp secret
	 * @author BRIAN ANDERSON
	 */
	public function __construct($key = NULL, $secret = NULL)
	{
		$this->set_key($key);
		$this->set_secret($secret);
	}
	
	/**
	 * set key
	 *
	 * @param string $key
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_key($key = NULL)
	{
		if ( ! isset($key)) 
		{
			Kohana::$environment === 'prod' ? $key = self::PROD_KEY : $key = self::DEV_KEY;
		}
		if ( ! is_string($key) )
		{
			trigger_error('set_key expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->key = $key;
	}
	
	/**
	 * get key
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function key()
	{
		return($this->key);
	}
	
	/**
	 * set secret
	 *
	 * @param string $secret
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_secret($secret = NULL)
	{
		if ( ! isset($secret)) 
		{
			Kohana::$environment === 'prod' ? $secret = self::PROD_SECRET : $secret = self::DEV_SECRET;
		}
		if ( ! is_string($secret) )
		{
			trigger_error('set_secret expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->secret = $secret;
	}
	
	/**
	 * get secret
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function secret()
	{
		return($this->secret);
	}
	
	/**
	 * set redirect_uri
	 *
	 * @param string $redirect_uri
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_redirect_uri($redirect_uri)
	{
		if ( ! is_string($redirect_uri) )
		{
			trigger_error('set_redirect_uri expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->redirect_uri = $redirect_uri;
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
	 * set OAUTH2 access_token
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
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function access_token()
	{
		return($this->access_token);
	}
	
	/**
	 * Returns uri which users must be redirected to in order to authenticate. sets code for CSRF
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function auth_uri()
	{
		// create and set state to session var
		$state = md5(uniqid(mt_rand(), TRUE));
		Session::instance()->set('linkedin_state', $state);
		// set scope based on app pref in the future
		$scope = urlencode('r_emailaddress r_basicprofile');
		return self::OAUTH2_ROOT.'authorization?response_type=code&client_id='.$this->key().'&scope='.$scope.'&state='.$state.'&redirect_uri='.$this->redirect_uri();
	}
	
	/**
	 * Check for csrf with session and returned state param
	 *
	 * @param string $state 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public function check_csrf($state)
	{
		$session_state = Session::instance()->get('linkedin_state', FALSE);
		if ( ! $session_state ) 
		{
			return FALSE;
		}
		Session::instance()->delete('linkedin_state');
		
		if ( $session_state !== $state )
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/**
	 * Returns uri which allows you to exchange code for access token
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function token_uri($code)
	{
		return self::OAUTH2_ROOT.'accessToken?grant_type=authorization_code&code='.$code.'&client_id='.$this->key().'&client_secret='.$this->secret().'&redirect_uri='.$this->redirect_uri();
	}
	
	/**
	 * set profile
	 *
	 * @param object $profile
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_profile($linkedin_id = NULL, $fields = NULL)
	{
		if ( ! $linkedin_id) 
		{
			$linkedin_id = '~'; // use currently logged in user
		}
		
		if ( ! isset($fields)) 
		{
			$fields = '(id,first-name,last-name,email-address,picture-url,positions)';
		}
		
		$uri = self::API_ROOT.self::VERSION.'/people/'.$linkedin_id.':'.$fields.'?oauth2_access_token='.$this->access_token().'&format=json';
		
		$request = Request::factory($uri);
		$response = json_decode($request->execute());
		if ( isset($response->error) )
		{
			throw new Exception('LinkedIn Error occurred with message '.$response->error->message.' ', 1);
		}
		
		$this->profile = $response;
	}
	
	/**
	 * Get user's profile
	 *
	 * @param string $linkedin_id 
	 * @return string JSON
	 * @author BRIAN ANDERSON
	 */
	public function profile()
	{
		return($this->profile);
	}
	
	/**
	 * get email
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function email()
	{
		if (isset($this->profile->emailAddress)) 
		{
			return $this->profile->emailAddress;
		}
		else
		{
			return NULL;
		}
	}
	
	public function id()
	{
		if (isset($this->profile->id)) 
		{
			return $this->profile->id;
		}
		else
		{
			return NULL;
		}
	}
	
}
