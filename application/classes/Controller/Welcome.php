<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Abstract {
	
	public function before()
	{
		$this->set_requires_login(FALSE);
		parent::before();
	}

	public function action_index()
	{
		$view = new View('main/welcome/index');
		$this->template->set('content', $view);
	}
	
	public function action_login()
	{
		echo Debug::vars('login here'); die;
	}
	
	public function action_connectWithFacebook()
	{
		$email = (string) get('email', '');
		$first_name = (string ) get('first_name', '');
		$last_name = (string) get('last_name', '');
		$gender = (string) get('gender', '');
		
		echo Debug::vars(get_defined_vars()); die;
	}

} // End Welcome
