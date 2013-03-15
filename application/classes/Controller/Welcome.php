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
		$view->header = new View('main/welcome/header');
		$this->template->set('content', $view);
		$this->add_css('main/welcome/index');
	}
	
	public function action_login()
	{
		echo Debug::vars('login here'); die;
	}

} // End Welcome
