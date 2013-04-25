<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Connect LinkedIn
 *
 * @author BRIAN ANDERSON
 */
class Controller_Connect_Linkedin extends Controller {
	
	public function action_index()
	{
		$security_code   = (string)  get('security_code', '');
		$connect_version = (string)  get('connect_version', '');
		$internal_app_id = (int)     get('app_id', 0);
		$dao_type        = (string)  get('dao_type', 'kohana');
		
		// set security code
		if ( ! $security_code) 
		{
			throw new Exception('Access Denied. Security code not provided', 1);
		}
		Session::instance()->set('security_code', $security_code);
		
		// create app and set internal_app_id
		Session::instance()->set('internal_app_id', $internal_app_id);
		$app_dao = Factory_Dao::create($dao_type, 'app', $internal_app_id);
		$app = Factory_Model::create($app_dao);
		
		// create linkedin api object
		$api = Factory_Linkedin::create($app);
		$this->redirect($api->auth_uri(), 302);
	}
	
	public function action_getAccessToken()
	{
		$error = (string) get('error', '');
		$code  = (string) get('code', '');
		$state = (string) get('state', '');
		
		// create app with internal_app_id, create linkedin api object
		$app_dao = Factory_Dao::create('kohana', 'app', Session::instance()->get('internal_app_id', FALSE));
		$app = Factory_Model::create($app_dao);
		$api = Factory_Linkedin::create($app);
		// error check
		if ($error) 
		{
			throw new Exception('LinkedIn Permission must be accepted to connect with '.$app->name().'. Please try again.', 1);
		}
		// check for csrf
		if ( ! $api->check_csrf($state) )
		{
			throw new Exception('A LinkedIn error occurred, please try again', 1);
		}
		$request = Request::factory( $api->token_uri($code) );
		$response = json_decode( $request->execute() );
		if ( ! isset($response->expires_in) OR ! isset($response->access_token)) 
		{
			throw new Exception('A LinkedIn error occurred, please try again', 1);
		}
		else
		{
			$api->set_access_token($response->access_token);
			$api->set_profile();
			
			// query db to determine if this app_user already exists or if a new user needs to be created
			$dao_app_user = Factory_Dao::create('kohana', 'app_user')->where('email', '=', $api->email())->and_where('app_id', '=', $app->id())->find();
			if ($dao_app_user->loaded()) 
			{
				$app_user = Factory_Model::create($dao_app_user);                                                                                                                                                 
			}
			else
			{
				// create new app_user
				$app_user = Model_App_User::create_with_email_and_app_id( Factory_Dao::create('kohana', 'app_user'), $api->email(), $app->id() );
			}
			// cache linkedin data using the linkedin_to_user adopter
			$li_user_adopter = Factory_Adopter::create('linkedin_to_user', $api->profile(), $app_user);
			$li_user_adopter->convert();
			//set access token and IP
			$app_user->set_linkedin_token($response->access_token, TRUE);
			$app_user->set_linkedin_token_created( time(), TRUE);
			$app_user->set_linkedin_token_expires( time() + $response->expires_in, TRUE);
			$app_user->set_ip(Request::$client_ip, TRUE);
			// activate and record login
			$app_user->set_state(MODEL_APP_USER::STATE_ACTIVE);
			$app_user->record_login( Factory_Dao::create('kohana', 'app_user_login') );
			// create sender object and redirect
			$sender = Factory_Sender::create('signup', 'linkedin', $app, $app_user);
			$this->redirect($sender->redirect_url(), 302);
		}
	}
	
	public function action_test()
	{
		$access_token = 'AQVpFQ0hCD0BnzZT-lVwh17pQETOLxrIY5j5VhGNExbM87GrE_CrdNUbuajkG3Vt6o4TqJLy99_ClES2tTDyUmnoG9B9h3w3DDkwpCDAsri9rv5Xrd2GCvIl90_ayW5F_7KGiTedSuSmYG8hIli2iSmu_GzbAbQHPsMeUM4778T08EysWzo';
		
		$app_dao = Factory_Dao::create('kohana', 'app', 1);
		$app = Factory_Model::create($app_dao);
		
		$api = Factory_Linkedin::create($app);
		$api->set_access_token($access_token);
		$api->set_profile();
		echo Debug::vars($api->profile()); die;
	}
	
}
