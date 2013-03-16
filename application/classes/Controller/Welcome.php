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
		$security_code = MD5(uniqid(mt_rand(), TRUE));
		Session::instance()->set('original_security_code', $security_code);
		
		$view = new View('main/welcome/index');
		$view->header = new View('main/welcome/header');
		$view->footer = new View('footer');
		$view->signup = new View('signup');
		$view->signup->security_code = $security_code;
		$view->security_code = $security_code;
		$this->template->set('content', $view);
		$this->add_css('main/welcome/index');
		$this->add_js('signup');
	}
	
	public function action_login()
	{
		$this->auto_login();
		echo Debug::vars('login here'); die;
	}
	
	public function action_connectWithFacebook()
	{
		$email                  = (string) get('email', '');
		$first_name             = (string) get('first_name', '');
		$last_name              = (string) get('last_name', '');
		$picture                = (string) get('picture', '');
		$birthday               = (string) get('birthday', '');
		$gender                 = (string) get('gender', '');
		$ip                     = (string) get('ip', '');
		$country_code           = (string) get('country_code', '');
		$timezone               = (int) get('timezone', 0);
		$facebook_id            = (string) get('facebook_id', '');
		$method                 = (string) get('method', '');
		$facebook_token         = (string) get('access_token', '');
		$security_code          = (string) get('security_code', '');
		$facebook_token_expires = (int) get('token_expires', 0);
		if ($facebook_token_expires)
		{
			$facebook_token_expires = time() + $facebook_token_expires;
		}
		
		// check security code
		if ( ! $security_code OR $security_code !== Session::instance()->get('original_security_code', FALSE))
		{
			throw new Exception('Access Denied. Please try again by clicking <a href="'.URL::base(TRUE).'">here</a>', 1); die;
		}
		
		// does user with given facebook_id already exist in system?
		$dao = Factory_Dao::create('kohana', 'user')->where('facebook_id', '=', $facebook_id)->find();
		if ($dao->loaded()) 
		{
			// create Model_User object and authenticate object
			$user = Factory_Model::create($dao);
			$auth = Factory_Authenticate::create( Auth::instance() );
			
			// update data
			if ($first_name) 
			{
				$user->set_first_name($first_name, TRUE);
			}
			if ($last_name) 
			{
				$user->set_last_name($last_name, TRUE);
			}
			if ($picture) 
			{
				$user->set_picture($picture, TRUE);
			}
			if ($birthday) 
			{
				$user->set_birthday( (int) strtotime($birthday), TRUE);
			}
			if ($gender) 
			{
				$user->set_gender($gender, TRUE);
			}
			if ($ip) 
			{
				$user->set_ip($ip, TRUE);
			}
			if ($country_code)
			{
				$user->set_country_code($country_code, TRUE);
			}
			if ($timezone) 
			{
				$user->set_timezone($timezone, TRUE);
			}
			if ($facebook_token) 
			{
				$user->set_facebook_token($facebook_token, TRUE);
				$user->set_facebook_token_created(time(), TRUE);
			}
			if ($facebook_token_expires) 
			{
				$user->set_facebook_token_expires($facebook_token_expires, TRUE);
			}
			$user->db_update();
			
			// login and redirect
			$auth->force_login( $user->email() );
			$this->redirect('base', 302);
		}
		
		//check for email
		
		
		// else create new user
		
		
		echo Debug::vars('complete'); die;
	}

} // End Welcome
