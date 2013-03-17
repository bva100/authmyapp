<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Base controller for core app functionality
 *
 * @author BRIAN ANDERSON
 */
class Controller_Home extends Controller_Abstract {
	
	public function before()
	{
		$this->set_requires_login(TRUE);
		$this->set_requires_admin(FALSE);
		parent::before();
		$this->add_css('main/home/index');
		$this->add_js('main/home/index');
		$this->add_css('main/home/header');
		$this->add_js('main/home/header');
		$this->add_css('main/home/sidebar');
	}
	
	public function action_logout()
	{
		$this->auth_object->logout();
		$this->redirect('welcome', 302);
	}
	
	public function action_index()
	{
		$view                = new View('main/home/index');
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'manage';
		$this->template->set('content', $view);
	}
	
	public function action_add()
	{
		$view = new View('main/home/add');
		$view->user = $this->user();
		$view->header = new view('main/home/header');
		$view->header->user = $this->user();
		$this->template->set('content', $view);
	}
}
