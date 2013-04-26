<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Twitter connect
 *
 * @author BRIAN ANDERSON
 */
class Controller_Connect_Twitter extends Controller {
	
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
		
		// create twitter api object, get auth_uri and redirect to dialog
		$api = Factory_Twitter::create($app);
		$api->set_redirect_uri(URL::base(TRUE).'connect_twitter/getAccessToken');
		$auth_uri = $api->auth_uri();
		$this->redirect($auth_uri, 302);
	}
	
	public function action_getAccessToken()
	{
		$oauth_token    = (string) get('oauth_token', '');
		$oauth_verifier = (string) get('oauth_verifier', '');
		if ( ! $oauth_token OR ! $oauth_verifier ) 
		{
			throw new Exception('A Twitter error has occurred. Please try again soon.', 1);
		}
		
		// create app
		$app_dao = Factory_Dao::create('kohana', 'app', Session::instance()->get('internal_app_id', 0) );
		$app = Factory_Model::create($app_dao);
		
		// create api object to get token creds
		$api = Factory_Twitter::create($app, 'abraham', array(
			'oauth_token' => $oauth_token,
			'oauth_verifier' => $oauth_verifier,
		));
		$api->set_access_token($oauth_verifier);
		$access_token_array = $api->access_token();
		
		// query db to determine if this app_user already exists or if a new user needs to be created
		$dao_app_user = Factory_Dao::create('kohana', 'app_user')->where('twitter_id', '=', $access_token_array['user_id'])->and_where('app_id', '=', $app->id())->find();
		if ($dao_app_user->loaded())
		{
			$app_user = Factory_Model::create($dao_app_user);                                                                                    
		}
		else
		{
			// // create new api object to query for full data
			$api = Factory_Twitter::create($app, 'abraham', array(
				'oauth_token' => $access_token_array['oauth_token'],
				'oauth_verifier' => $access_token_array['oauth_token_secret'],
			));
			
			// $connection = new TwitterOAuth($app->twitter_key(), $app->twitter_secret(), $access_token_array['oauth_token'], $access_token_array['oauth_token_secret']);
			
			$account = $api->sdk()->get('account/verify_credentials');
			echo Debug::vars($account); die;
			
			// create new app_user
			//$app_user = Model_App_User::create_with_email_and_app_id( Factory_Dao::create('kohana', 'app_user'), $api->email(), $app->id() );
		}
		
	}
	
}
