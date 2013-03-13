<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Facebook Connect Auth2 style controller
 *
 * @author BRIAN ANDERSON
 */
class Controller_Connect_Facebook extends Controller {
	
	/**
	 * fb app id
	 *
	 * @var string
	 */
	private $app_id;
	
	/**
	 * Fb app secret
	 *
	 * @var string
	 */
	private $secret;
	
	/**
	 * An app object. Used if default is not being authed.
	 *
	 * @var Model_App object
	 */
	private $app;
	
	/**
	 * set app_id
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_app_id($app_id = NULL)
	{
		$this->app_id = $app_id;
	}
	
	/**
	 * get app_id
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function app_id()
	{
		return($this->app_id);
	}
	
	/**
	 * set secret
	 *
	 * @param string $secret
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_secret($secret)
	{
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
		return($this->app);
	}
	
	
 	public function set_app_id_and_secret($internal_app_id, $dao_type = NULL)
	{
		if ( ! is_int($internal_app_id)) 
		{
			trigger_error('set_app_id_and_secret expects argument 1, internal_ap_id, to be int', E_USER_WARNING);
		}
		if ( isset($dao_type) AND ! is_string($dao_type)) 
		{
			trigger_error('set_app_id_and_secret expects argument 2, dao_type, to be string', E_USER_WARNING);
		}
		
		if ($internal_app_id === 0) 
		{
			// use default appId and secret
			$config_array = Factory_Facebook::$default_config;
			$this->set_app_id($config_array['appId']);
			$this->set_secret($config_array['secret']);
		}
		
		// save internal_app_id and dao_type to session
		Session::instance()->set('internal_app_id', $internal_app_id);
		Session::instance()->set('fb_dao_type', $dao_type);
		
		// get app via dao and set to $this->app
		
		// set $this->app's app_id and secret
		
	}
	
	/**
	 * Send user to login dialog
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function action_index()
	{
		$internal_app_id = (int) get('internal_app_id', 0);
		$dao_type        = (string) get('dao_type', 'kohana');
		
		if ( ! isset($_REQUEST['code'])) 	// send to auth dialog
		{
			// set appId and secrete
			$this->set_app_id_and_secret($internal_app_id, $dao_type);

			// create state var and store into session
			Session::instance()->set('fb_state', md5(uniqid(rand(), TRUE)));

			// create request
			$url = 'https://www.facebook.com/dialog/oauth?client_id='.$this->app_id().'&redirect_uri='.URL::base(TRUE).'connect_facebook&state='.Session::instance()->get('fb_state', '');

			// create scope string
			if ($internal_app_id === 0) 
			{
				$scope = '&scope=email,user_birthday';
			}

			// redirect to dialog url
			$dialog_url = $url.$scope;
			$this->redirect($dialog_url, 302);
		}
		else
		{
			// get access token
			
			$code = $_REQUEST['code'];
			// check fb state
			
			if( ! Session::instance()->get('fb_state', FALSE) OR (Session::instance()->get('fb_state', '') !== $_REQUEST['state']))
			{
				throw new Exception("A Facebook error occurred. Please try again soon.", 1);
			}

			// set appId and secret
			$this->set_app_id_and_secret(Session::instance()->get('internal_app_id', 0), Session::instance()->get('fb_dao_type', 'kohana'));

			$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->app_id().'&client_secret='.$this->secret().'&code='.$code.'&redirect_uri='.URL::base(TRUE).'connect_facebook';
			
			$request  = Request::factory($token_url);
			$response = $request->execute();
			
			// redirect to sender
			$this->redirect('connect_facebook/sender?'.$response);
		}
	}
	
	public function action_sender()
	{
		$access_token = (string) get('access_token', '');
		$expires      = (int)    get('expires', '');
		$dao_type     = Session::instance()->get('dao_type', 'kohana');
		$app_id       = Session::instance()->get('internal_app_id', 0);
		
		// set app id and secret
		$this->set_app_id_and_secret(Session::instance()->get('internal_app_id', 0), Session::instance()->get('fb_dao_type', 'kohana'));
		
		// create objects
		$app            = Factory_Model::create( Factory_Dao::create($dao_type, 'app', $app_id) );
		$facebook       = Factory_Facebook::create(array('appId' => $this->app_id(), 'secret' => $this->secret()));
		$facebook->setAccessToken($access_token);
		$app_user_fb_data = $facebook->api('/me');
		if ( ! isset($app_user_fb_data['email'])) 
		{
			throw new Exception('Email was not provided by Facebook. Please try again soon.', 1);
		}
		$app_user_email = $app_user_fb_data['email'];
		
		
		echo Debug::vars($app_user_email); die;
		
		// are we using authmyapp or client app?? THEN create this factory_adopter class :)
		
		$dao_app_user = Dao_Factory::create('kohana', 'app_user')->where('email', '=', $app_user_email)->and_where('app_id', '=', $app_id)->find();
		if ($dao_app_user->loaded()) 
		{
			// update user data
			$fb_user_adopter = Factory_Adopter::create('facebook_to_user', $app_user_fb_data, $app_user);
		}
		else
		{
			// create new db with facebook data
			// $app_user = Model_App_User::create_with_email( Dao_Factory:: )
		}
		
		
	}
	
	
}
