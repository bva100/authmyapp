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
		echo Debug::vars($user->facebook_id()); die;
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
			echo Debug::vars($org->name(), $org); die;
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
			echo Debug::vars($app->name(), $app); die;
		}
	}
	
	public function action_appUserCreate()
	{
		$email = (string) get('email', 'brian.anderson@ovooko.com');
		$app_id = (int) get('app_id', 2);
		
		$dao = Factory_Dao::create('kohana', 'app_user');
		$app_user = Model_App_User::create_with_email_and_app_id($dao, $email, $app_id);
		
		echo Debug::vars($app_user); die;
	}
	
}
