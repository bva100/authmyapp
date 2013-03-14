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
		
		$view = new View('main/demo/index');
		$view->header = new View('main/demo/header');
		$this->template->set('content', $view);
		
		$this->add_css('main/demo/index');
		$this->add_js('main/demo/index');
	}
	
	public function action_connect()
	{
		$email        = (string) get('email', '');
		$first_name   = (string) get('first_name', '');
		$last_name    = (string) get('last_name', '');
		$picture      = (string) get('picture', '');
		$birthday     = (string) get('birthday', '');
		$gender       = (string) get('gender', '');
		$ip           = (string) get('ip', '');
		$country_code = (string) get('country_code', '');
		$facebook_id  = (string) get('facebook_id', '');
		
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
		
		$this->template->set('content', $view);
		$this->add_css('main/demo/connect');
		$this->add_js('main/demo/connect');
	}
	
	
	
}
