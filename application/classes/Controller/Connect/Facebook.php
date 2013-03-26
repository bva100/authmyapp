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
	
	/**
	 * Set's controller's app_id and secret
	 *
	 * @param int $internal_app_id. Id representing authmyapp client app id (internal)
	 * @param string $dao_type 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
 	public function set_app_id_and_secret($internal_app_id, $dao_type)
	{
		if ( ! is_int($internal_app_id)) 
		{
			trigger_error('set_app_id_and_secret expects argument 1, internal_ap_id, to be int', E_USER_WARNING);
		}
		if ( ! is_string($dao_type)) 
		{
			trigger_error('set_app_id_and_secret expects argument 2, dao_type, to be string', E_USER_WARNING);
		}
		
		// get app object
		$dao = Factory_Dao::create($dao_type, 'app', $internal_app_id);
		$app = Factory_Model::create($dao);
		
		// get app facebook config and set to controller's vars
		$config_array = $app->facebook_config();
		$this->set_app_id($config_array['appId']);
		$this->set_secret($config_array['secret']);
		
		// save internal_app_id and dao_type to session
		Session::instance()->set('internal_app_id', $internal_app_id);
		Session::instance()->set('fb_dao_type', $dao_type);
	}
	
	/**
	 * Send user to login dialog
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function action_index()
	{
		$security_code   = (string)  get('security_code', '');
		$connect_version = (string)  get('connect_version', '');
		$internal_app_id = (int)     get('app_id', 1);
		$dao_type        = (string)  get('dao_type', 'kohana');
		
		if ( ! isset($_REQUEST['code'])) 	// send to auth dialog
		{
			// set appId and secret
			$this->set_app_id_and_secret($internal_app_id, $dao_type);
			
			// set security code to session
			if ( ! $security_code) 
			{
				throw new Exception('Access Denied. Security code not provided', 1);
			}
			else
			{
				$_SESSION['security_code'] = $security_code;
			}
			
			// create state var and store into session
			$_SESSION['fb_state'] = md5(uniqid(mt_rand(), TRUE));
			
			// create request
			$url = 'https://www.facebook.com/dialog/oauth?client_id='.$this->app_id().'&redirect_uri='.URL::base(TRUE).'connect_facebook&state='.$_SESSION['fb_state'];

			// create scope flexibility via app in the future
			$scope = '&scope=email,user_birthday';

			// redirect to dialog url
			$dialog_url = $url.$scope;
			
			$this->redirect($dialog_url, 302);
		}
		else if(isset($_REQUEST['code']))
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
			
			// create url and send request
			$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->app_id().'&client_secret='.$this->secret().'&code='.$code.'&redirect_uri='.URL::base(TRUE).'connect_facebook';
			
			$request  = Request::factory($token_url);
			$response = $request->execute();
			if ($response) 
			{
				$token_params = (string)$response;
			}
			else
			{
				throw new Exception('A Facebook error has occurred. Please try again soon.', 1);
			}
			
			// redirect to sender
			$this->redirect('connect_facebook/sender?'.$token_params);
		}
		else
		{
			throw new Exception('A Facebook error has occurred (new code not received). Please try again soon.', 1);
		}
	}
	
	public function action_sender()
	{
		$access_token = (string) get('access_token', '');
		$expires      = (int)    get('expires', '');
		$dao_type     = Session::instance()->get('dao_type', 'kohana');
		$app_id       = Session::instance()->get('internal_app_id', 1);
		
		// set app id and secret
		$this->set_app_id_and_secret(Session::instance()->get('internal_app_id', 0), Session::instance()->get('fb_dao_type', 'kohana'));
		
		// create needed objects
		$app            = Factory_Model::create( Factory_Dao::create($dao_type, 'app', $app_id) );
		$facebook       = Factory_Facebook::create(array('appId' => $this->app_id(), 'secret' => $this->secret()));
		$facebook->setAccessToken($access_token);
		
		$app_user_fb_data = $facebook->api('/me', 'GET');
		
		// get app_user email
		if ( ! isset($app_user_fb_data['email'])) 
		{
			throw new Exception('A Facebook error has occurred (Email not provided). Please try again soon.', 1);
		}
		$app_user_email = $app_user_fb_data['email'];
		
		// query db to determine if this app_user already exists or if a new user one needs to be created
		$dao_app_user = Factory_Dao::create('kohana', 'app_user')->where('email', '=', $app_user_email)->and_where('app_id', '=', $app_id)->find();
		if ($dao_app_user->loaded()) 
		{
			$app_user = Factory_Model::create($dao_app_user);                                                                                                                                                 
		}
		else
		{
			// create new app_user
			$app_user = Model_App_User::create_with_email_and_app_id( Factory_Dao::create($dao_type, 'app_user'), $app_user_email, $app_id );
		}
		
		// cache fb data using the facebook_to_user adopter
		$fb_user_adopter = Factory_Adopter::create('facebook_to_user', $app_user_fb_data, $app_user);
		$fb_user_adopter->convert();
		
		// cache token data
		$app_user->set_facebook_token($access_token, TRUE);
		$app_user->set_facebook_token_created(time(), TRUE);
		$app_user->set_facebook_token_expires(time() + $expires);
		
		// cache IP
		$app_user->set_ip(Request::$client_ip);
		
		// cache picture
		$app_user->set_picture('https://graph.facebook.com/'.$app_user->facebook_id().'/picture?type=large');
		
		// create sender object and redirect
		$sender = Factory_Sender::create('signup', 'facebook', $app, $app_user);
		if ($app_id === 1) 
		{
			$sender->set_access_token($access_token);
			$sender->set_access_token_expires($expires);
		}
		
		// record login
		$app_user->record_login( Factory_Dao::create('kohana', 'app_user_login') );
		
		$url = $sender->redirect_url();
		$this->redirect($url, 302);
	}
	
	
}
