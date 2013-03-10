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
	
}
