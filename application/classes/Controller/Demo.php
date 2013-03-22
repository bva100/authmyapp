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
	
	public function action_connect()
	{
		$email         = (string) get('email', '');
		$first_name    = (string) get('first_name', '');
		$last_name     = (string) get('last_name', '');
		$picture       = (string) get('picture', '');
		$birthday      = (string) get('birthday', '');
		$gender        = (string) get('gender', '');
		$ip            = (string) get('ip', '');
		$country_code  = (string) get('country_code', '');
		$facebook_id   = (string) get('facebook_id', '');
		$method        = (string) get('method', '');
		$security_code = (string) get('security_code', '');
		
		// check security code
		if ($security_code !== Session::instance()->get('original_security_code', FALSE)) 
		{
			throw new Exception('Access Denied. Please try again by clicking <a href="demo">here</a>', 1);
		}
		
		$view = new View('main/demo/connect');
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
		$view->method       = $method;
		
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
		$method       = (string) post('method', '');
		
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
		$view->method       = $method;
		
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
