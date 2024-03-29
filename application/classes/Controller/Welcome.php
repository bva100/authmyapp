<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Abstract {
	
	public function before()
	{
		$this->set_requires_login(FALSE);
		parent::before();
	}

	public function action_index()
	{
		$this->auto_login();
		$security_code = $this->security_code();
		
		$view = new View('main/welcome/index');
		$view->security_code = $security_code;
		$view->header = new View('main/welcome/header');
		$view->footer = new View('footer');
		$view->signup = new View('signup');
		$view->signup->security_code = $security_code;
		$this->template->set('content', $view);
		$this->add_css('main/welcome/index');
		$this->add_js('signup');
	}
	
	public function action_login()
	{
		$this->auto_login();
		
		$view = new View('main/welcome/login');
		$view->security_code = $this->security_code();
		$view->header = new View('main/welcome/header');
		$view->footer = new View('footer');
		$this->template->set('content', $view);
		$this->add_css('main/welcome/index');
	}
	
	public function action_signup()
	{
		$this->auto_login();
		
		$view = new View('main/welcome/signup');
		$view->security_code = $this->security_code();
		$view->header = new View('main/welcome/header');
		$view->footer = new View('footer');
		$this->template->set('content', $view);
		$this->add_css('main/welcome/index');
	}
	
	public function action_pricing()
	{
		$dao = Factory_Dao::create('kohana', 'plan');
		$plans = Model_Plan::all($dao);
		
		$view = new View('main/welcome/pricing');
		$view->plans = $plans;
		$view->header = new View('main/welcome/header');
		$view->footer = new View('footer');
		$this->template->set('content', $view);
		$this->add_css('main/welcome/index');
	}
	
	public function action_amaconnect()
	{
		$security_code = (string ) get('security_code', 'nada');
		$data_source   = (string ) get('data_source', 'facebook');
		$user_id       = (int) get('user_id', 0);
		
		// validate security code
		if ( ! $security_code OR $security_code !== Session::instance()->get('original_security_code', FALSE))
		{
			throw new Exception('Access Denied. Please try again by clicking <a href="'.URL::base(TRUE).'">here</a>', 1); die;
		}
		// create authmyapp Model_App object
		$app_dao = Factory_Dao::create('kohana', 'app', 1);
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
		// status
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		// close
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
		
		// create auth object
		$auth = Factory_Authenticate::create( Auth::instance() );
		
		// does user with given email already exist in system?
		$dao = Factory_Dao::create('kohana', 'user')->where('email', '=', $response->email)->find();
		if ($dao->loaded()) 
		{
			// create Model_User object
			$user = Factory_Model::create($dao);
			
			// update data
			if (isset($response->name->first))
			{
				$user->set_first_name($response->name->first, TRUE);
			}
			if (isset($response->name->last))
			{
				$user->set_last_name($response->name->last, TRUE);
			}
			if (isset($response->picture))
			{
				$user->set_picture($response->picture, TRUE);
			}
			if (isset($response->birthday))
			{
				$user->set_birthday($response->birthday, TRUE);
			}
			if (isset($response->gender))
			{
				$user->set_gender($response->gender, TRUE);
			}
			if (isset($response->ip))
			{
				$user->set_ip($response->ip, TRUE);
			}
			if (isset($response->country_code))
			{
				$user->set_country_code($response->country_code, TRUE);
			}
			if (isset($response->timezone))
			{
				$user->set_timezone($response->timezone, TRUE);
			}
			if (isset($response->facebook->id))
			{
				$user->set_facebook_id($response->facebook->id, TRUE);
			}
			if (isset($response->facebook->token))
			{
				$user->set_facebook_token($response->facebook->token, TRUE);
				$user->set_facebook_token_created(time(), TRUE);
			}
			if (isset($response->facebook->token_expires))
			{
				$user->set_facebook_token_expires($response->facebook->token_expires, TRUE);
			}
			if (isset($response->linkedin->id)) 
			{
				$user->set_linkedin_id($response->linkedin->id, TRUE);
			}
			if (isset($response->linkedin->token)) 
			{
				$user->set_linkedin_token($response->linkedin->token, TRUE);
				$user->set_linkedin_token_created(time(), TRUE);
			}
			if (isset($response->linkedin->token_expires)) 
			{
				$user->set_linkedin_token_expires($response->linkedin->token_expires, TRUE);
			}
			$user->db_update();
			
			// login and redirect
			$auth->force_login( $user->email() );
			$this->redirect('home', 302);
		}
		else
		{
			// create new user
			$dao = Factory_Dao::create('kohana', 'user');
			$user = Model_User::create_with_email($dao, $response->email);
			$user->set_rand_password( Factory_Hash::create_via_type('kohana_auth') );
			if (isset($response->name->first))
			{
				$user->set_first_name($response->name->first, TRUE);
			}
			if (isset($response->name->last))
			{
				$user->set_last_name($response->name->last, TRUE);
			}
			if (isset($response->picture))
			{
				$user->set_picture($response->picture, TRUE);
			}
			if (isset($response->birthday))
			{
				$user->set_birthday($response->birthday, TRUE);
			}
			if (isset($response->gender))
			{
				$user->set_gender($response->gender, TRUE);
			}
			if (isset($response->ip))
			{
				$user->set_ip($response->ip, TRUE);
			}
			if (isset($response->country_code))
			{
				$user->set_country_code($response->country_code, TRUE);
			}
			if (isset($response->timezone))
			{
				$user->set_timezone($response->timezone, TRUE);
			}
			if (isset($response->facebook->id))
			{
				$user->set_facebook_id($response->facebook->id, TRUE);
			}
			if (isset($response->facebook->token))
			{
				$user->set_facebook_token($response->facebook->token, TRUE);
				$user->set_facebook_token_created(time(), TRUE);
			}
			if (isset($response->facebook->token_expires))
			{
				$user->set_facebook_token_expires($response->facebook->token_expires, TRUE);
			}
			if (isset($response->linkedin->id)) 
			{
				$user->set_linkedin_id($response->linkedin->id, TRUE);
			}
			if (isset($response->linkedin->token)) 
			{
				$user->set_linkedin_token($response->linkedin->token, TRUE);
				$user->set_linkedin_token_created(time(), TRUE);
			}
			if (isset($response->linkedin->token_expires)) 
			{
				$user->set_linkedin_token_expires($response->linkedin->token_expires, TRUE);
			}
			$user->set_state(Model_User::STATE_ACTIVE);
			
			// login and redirect
			$auth->force_login( $user->email() );
			$this->redirect('home', 302);
		}
	}
	
	/**
	 * Create an original security code, set to session and return code
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function security_code()
	{
		$security_code = md5(uniqid(mt_rand(), TRUE));
		Session::instance()->set('original_security_code', $security_code);
		return $security_code;
	}

} // End Welcome
