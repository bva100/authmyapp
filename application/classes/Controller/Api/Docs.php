<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Api Docs
 *
 * @author BRIAN ANDERSON
 */
class Controller_Api_Docs extends Controller_Abstract {
	
	public function before()
	{
		$this->set_requires_login(FALSE);
		$this->set_requires_admin(FALSE);
		parent::before();
	}
	
	public function action_index()
	{
		$view = new View('main/apidocs/index');
		$view->header = new View('main/welcome/header');
		$this->template->set('content', $view);
		$this->add_css('main/welcome/index');
	}
	
}
