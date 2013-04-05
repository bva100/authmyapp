<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Sales demo controller
 *
 * @author BRIAN ANDERSON
 */
class Controller_Demo extends Controller_Abstract {
	
	public function before()
	{
		$this->set_requires_login(FALSE);
		parent::before();
	}
	
	public function action_index()
	{
		$this->template->title = 'Best Widgets Ever Demo';
		
		if (Session::instance()->get('original_security_code', FALSE)) 
		{
			$security_code = Session::instance()->get('original_security_code', '');
		}
		else
		{
			$security_code = md5(uniqid(mt_rand(), TRUE));
			Session::instance()->set('original_security_code', $security_code);
		}
		
		$view = new View('main/demo/index');
		$view->header = new View('main/demo/header');
		$view->security_code = $security_code;
		$this->template->set('content', $view);
		
		$this->add_css('main/demo/index');
		$this->add_js('main/demo/index');
	}
	
	public function action_amaconnect()
	{
		$security_code = (string ) get('security_code', 'nada');
		$data_source   = (string ) get('data_source', '');
		$user_id       = (int) get('user_id', 0);
		
		// check security code
		if ($security_code !== Session::instance()->get('original_security_code', FALSE)) 
		{
			throw new Exception('Access Denied. Please try again by clicking <a href="demo">here</a>', 1);
		}
		
		// create authmyapp example Model_App object
		$app_dao = Factory_Dao::create('kohana', 'app', 2);
		$app = Factory_Model::create($app_dao);
		
		// get user data via api via curl
		$headers = array('Content-Type: application/json');
		if ($app->access_token())
		{
			$headers[] = 'Authorization: Bearer '.$app->access_token();
		}
		
		// create uri
		$uri = URL::base(TRUE).'api/users.json?user_id='.$user_id.'&access_token='.urlencode($app->access_token()).'&v=.8';
		
		//cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, 'AuthMyApp PHP SDK api_version=.8');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_URL, $uri);
		
		// response
		$response = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$response = json_decode($response);
		
		// check status
		if ($http_status !== 200) 
		{
			// error occured. Log.
			Kohana::$log->add(Log::ERROR, 'AmaConnect error code = '.$response->error_code.' with message '.$response->message);
			throw new Exception('A '.$data_source.' error has occurred. Please try again soon.', 1);
		}
		if ( ! $response->email) 
		{
			throw new Exception('Email permissions must be accepted in order to continue. Please try again.', 1);
		}
		
		$view = new View('main/demo/connect');
		$view->header = new View('main/demo/header');
		$view->email        = $response->email;
		$view->first_name   = $response->name->first;
		$view->last_name    = $response->name->last;
		$view->picture      = $response->facebook->picture;
		$view->birthday     = $response->birthday;
		$view->gender       = $response->gender;
		$view->ip           = $response->ip;
		$view->country_code = $response->country_code;
		$view->facebook_id  = $response->facebook->id;
		$view->data_source  = $data_source;
		
		$this->template->set('content', $view);
		$this->add_css('main/demo/connect');
		$this->add_js('main/demo/connect');
	}
	
	public function action_app()
	{
		$email        = (string) post('email', '');
		$first_name   = (string) post('first_name', '');
		$last_name    = (string) post('last_name', '');
		$picture      = (string) post('picture', '');
		$birthday     = (string) post('birthday', 0);
		$gender       = (string) post('gender', '');
		$ip           = (string) post('ip', '');
		$country_code = (string) post('country_code', '');
		$facebook_id  = (string) post('facebook_id', '');
		$data_source  = (string) post('data_source', '');
		
		$view = new View('main/demo/app');
		$view->header = new View('main/demo/header');
		$view->email        = $email;
		$view->first_name   = $first_name;
		$view->last_name    = $last_name;
		$view->picture      = $picture;
		$view->birthday     = $birthday;
		$view->gender       = $gender;
		$view->ip           = $ip;
		$view->country_code = $country_code;
		$view->facebook_id  = $facebook_id;
		$view->data_source  = $data_source;
		
		$this->template->set('content', $view);
		$this->add_css('main/demo/app');
		$this->add_js('main/demo/app');
	}
	
	public function action_form()
	{
		$view = new View('main/demo/form');
		$this->template->set('content', $view);
	}
	
}
