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
			'oauth_token_secret' => $oauth_verifier,
		));
		$api->set_access_token($oauth_verifier);
		$access_token_array = $api->access_token();
		// // create new api object using obtainer access_token array to query for full data
		$api = Factory_Twitter::create($app, 'abraham', array(
			'oauth_token' => $access_token_array['oauth_token'],
			'oauth_token_secret' => $access_token_array['oauth_token_secret'],
		));
		$api->set_profile();
		$api->set_name_parser( Factory_Nameparser::create() );
		
		// query db to determine if this app_user already exists or if a new user needs to be created
		$dao_app_user = Factory_Dao::create('kohana', 'app_user')->where('twitter_id', '=', (int)$access_token_array['user_id'])->and_where('app_id', '=', $app->id())->find();
		if ($dao_app_user->loaded())
		{
			$app_user = Factory_Model::create($dao_app_user);                                                                                    
		}
		else
		{
			// create new app_user
			$app_user = Model_App_User::create( Factory_Dao::create('kohana', 'app_user') );
			$app_user->set_app_id($app->id());
		}
		// cache twitter data using the twitter_to_user adopter
		$li_user_adopter = Factory_Adopter::create('twitter_to_user', $api, $app_user);
		$li_user_adopter->convert();
		//set access token and IP
		$app_user->set_twitter_oauth_token($access_token_array['oauth_token'], TRUE);
		$app_user->set_twitter_oauth_token_secret($access_token_array['oauth_token_secret'], TRUE);
		$app_user->set_ip(Request::$client_ip, TRUE);
		// activate and record login
		$app_user->set_state(MODEL_APP_USER::STATE_ACTIVE);
		$app_user->record_login( Factory_Dao::create('kohana', 'app_user_login') );
		// create sender object and redirect
		$sender = Factory_Sender::create('signup', 'twitter', $app, $app_user);
		$this->redirect($sender->redirect_url(), 302);
	}
	
	public function action_test()
	{
		$data_source   = (string ) get('data_source', 'twitter');
		$user_id       = (int) get('user_id', 21);
		
		// create uri
		$dao = Factory_Dao::create('kohana', 'app', 1);
		$app = Factory_Model::create($dao);
		$uri = URL::base(TRUE).'api/users.json?user_id='.$user_id.'&access_token='.urlencode($app->access_token()).'&v=.8';
		
		//cURL
		$headers = array('Content-Type: application/json');
		if ($app->access_token())
		{
			$headers[] = 'Authorization: Bearer '.$app->access_token();
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, 'AuthMyApp PHP SDK api_version=.8');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_URL, $uri);
		// response
		$response = curl_exec($ch);
		// status
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		// close
		curl_close($ch);
		$response = json_decode($response);
		
		echo Debug::vars($response); die;
	}
	
}
