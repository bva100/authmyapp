<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Use for testing purposes only. Cannot create in Prod.
 *
 * @author BRIAN ANDERSON
 */
class Controller_Test extends Controller {
	
	public function before()
	{
		if (Kohana::$environment === 'prod') 
		{
			die('access denied');
		}
	}
	
	public function action_index()
	{
		echo Debug::vars('test controller functional'); die;
	}
	
	public function action_authenticate()
	{
		$authenticate = Factory_Authenticate::create( Auth::instance() );
		echo Debug::vars($authenticate); die;
	}
	
	public function action_hash()
	{
		$hash = Factory_Hash::create( Auth::instance() );
		$string = 'yeah doggie dog';
		echo Debug::vars($hash->name(), $hash->hash($string)); die;
	}
	
	public function action_UserCreate()
	{
		$dao  = Factory_Dao::create('kohana', 'user');
		$user = Model_User::create_with_email($dao, 'brianvanderson@gmail.com');
		echo Debug::vars($user); die;
	}
	
	public function action_userAddRole()
	{
		$user_id = (int) get('user_id', 1);
		$role = (string) get('role', 'login');
		
		$dao = Factory_Dao::create('kohana', 'user', $user_id);
		$user = Factory_Model::create($dao);
		$user->add_role($role);
	}
	
	public function action_userPassword()
	{
		$user_id = (int) get('user_id', 1);
		$password = (string) get('password', '');
		
		$dao = Factory_Dao::create('kohana', 'user', $user_id);
		$user = Factory_Model::create($dao);
		
		$hash_algo = Factory_Hash::create( Auth::instance() );
		
		$user->set_password($hash_algo, $password);
		echo Debug::vars($user->password()); die;
	}
	
	public function action_userFacebookId()
	{
		$user_id = (int) get('user_id', 1);
		$facebook_id = get('facebook_id', 0);
		
		$dao = Factory_Dao::create('kohana', 'user', $user_id);
		$user = Factory_Model::create($dao);
		
		$user->set_facebook_id($facebook_id);
		$this->response->body( $user->facebook_id() );
	}
	
	public function action_login()
	{
		$email = (string) get('email', 'brianvanderson@gmail.com');
		$password = (string) get('password', 'dress0159');
		
		$auth = Factory_Authenticate::create( Auth::instance() );
		$result = $auth->login($email, $password);
		
		echo Debug::vars($result); die;
	}
	
	public function action_forceLogin()
	{
		$email = (string) get('email', 'brianvanderson@gmail.com');
		
		$auth = Factory_Authenticate::create( Auth::instance() );
		$result = $auth->force_login($email);
		$this->response->body( $result );
	}
	
	public function action_logout()
	{
		$auth = Factory_Authenticate::create( Auth::instance() );
		$auth->logout();
		$this->response->body('logged out');
	}
	
	public function action_getUser()
	{
		$auth = Factory_Authenticate::create( Auth::instance() );
		$dao_user = $auth->get_user();
		if ( ! $dao_user ) 
		{
			die('not logged in');
		}
		$user = Factory_Model::create($dao_user);
		$this->response->body($user->email());
	}
	
	public function action_userAddOrg()
	{
		$org_id = (int) get('org_id', 2);
		$user_id = (int) get('user_id', 1);
		
		$dao = Factory_Dao::create('kohana', 'user', $user_id);
		$user = Factory_Model::create($dao);
		
		// $user->add_organization($org_id);
		
		foreach ($user->organizations() as $org) 
		{
			echo $org->name().'<br>';
		}
		die('<hr>end');
	}
	
	public function action_createOrg()
	{
		$name = (string) get('name', '');
		$url = get('url', NULL);
		
		$dao = Factory_Dao::create('kohana', 'organization');
		$org = Model_Organization::create_with_name($dao, $name);
		if (is_bool($org)) 
		{
			die('already exists!');
		}
		else
		{
			$this->response->body($org->name());
		}
	}
	
	public function action_appCreate()
	{
		$app_name = (string) get('app_name', 'fast blogger');
		$org_id = (int) get('org_id', 4);
		
		$dao = Factory_Dao::create('kohana', 'app');
		$app = Model_App::create_with_name_and_organization_id($dao, $app_name, $org_id);
		if (is_bool($app) AND $app !== FALSE) 
		{
			die('already exists!');
		}
		else
		{
			$this->response->body($app->name());
		}
	}
	
	public function action_appSecret()
	{
		$app_id = (int) get('app_id', 1);
		
		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		$app->set_secret();
		$this->response->body('new secret is '.$app->secret());
	}
	
	public function action_appUserCreate()
	{
		$email = (string) get('email', 'brian.anderson@ovooko.com');
		$app_id = (int) get('app_id', 2);
		
		$dao = Factory_Dao::create('kohana', 'app_user');
		$app_user = Model_App_User::create_with_email_and_app_id($dao, $email, $app_id);
		$this->response->body($app_user->email());
	}
	
	public function action_facebook()
	{
		$facebook = Factory_Facebook::create();
		
		// get user via fb session
		$fb_user = $facebook->getUser();
		
		if ($fb_user) {
			try 
			{
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $facebook->api('/me');
				echo Debug::vars($user_profile);
			} 
			catch (FacebookApiException $e) 
			{
				error_log($e);
				$fb_user = NULL;
			}
		}
		
		// Login or logout url will be needed depending on current user state.
		if ($fb_user) 
		{
			$this->response->body('you are currently logged into facebook. <a href="'.$facebook->getLogoutUrl().'">log out</a>');
		}
		else
		{
			$loginUrl = $facebook->getLoginUrl();
			$this->response->body('you are not logged into facebook. <a href="'.$loginUrl.'">log in</a>');
		}
	}
	
	public function action_facebookLogout()
	{
		$facebook = Factory_Facebook::create();
		$fb_user = $facebook->getUser();
		if ($fb_user) 
		{
			echo '<a href="'.$facebook->getLoginUrl().'">log out</a>';
		}
		else
		{
			$this->response->body('Already logged out');
		}
	}
	
	public function action_pic()
	{
		$facebook = Factory_Facebook::create();
		$fb_user = $facebook->getUser();
		if ( ! $fb_user ) 
		{
			echo '<a href="'.$facebook->getLoginUrl().'">Log In</a>';
		}
		$pic = 'https://graph.facebook.com/'.$fb_user.'/picture?width=300&height=300';
		echo Debug::vars($pic); die;
	}
	
	public function action_plan()
	{
		$dao = Factory_Dao::create('kohana', 'plan', 1);
		$plan = Factory_Model::create($dao);
		$this->response->body($plan);
	}
	
	public function action_plans()
	{
		$dao = Factory_Dao::create('kohana', 'plan');
		$plans = Model_Plan::all($dao);
		foreach ($plans as $plan) 
		{
			echo $plan->name().'<br>';
		}
	}
	
	public function action_appDomain()
	{
		$domain_var = (string) get('var', 'www.doggiedoggie.com');
		$app_id = (int) get('app_id', 12);

		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		
		$this->response->body($app->domain());
	}
	
	public function action_appSalt()
	{
		$app_id = (int) get('app_id', 12);

		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		
		echo Debug::vars($app->set_salt(), $app->salt()); die;
	}
	
}
