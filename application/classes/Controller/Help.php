<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Help Controller
 *
 * @author BRIAN ANDERSON
 */
class Controller_Help extends Controller_Welcome {
	
	public function before()
	{
		parent::before();
		$this->add_css('main/welcome/index');
		$this->add_css('main/welcome/help');
	}
	
	public function set_view_props($view_string)
	{
		$this->set_view( new View($view_string) );
		isset($this->user) ? $this->set_view_header('main/home/header') : $this->set_view_header('main/welcome/header');
		$this->set_view_sidebar('main/help/sidebar');
		$this->set_view_footer('footer');
	}
	
	public function action_index()
	{
		$this->set_view_props('main/help/index');
		$this->set_temp_view();
	}
	
	public function action_signups()
	{
		$this->set_view_props('main/help/signups');
		$this->set_view_page('signups');
		$this->set_temp_view();
	}
	
	public function action_logins()
	{
		$this->set_view_props('main/help/logins');
		$this->set_view_page('logins');
		$this->set_temp_view();
	}
	
	public function action_dataReceived()
	{
		$this->set_view_props('main/help/dataReceived');
		$this->set_view_page('dataReceived');
		$this->set_temp_view();
	}
	
}
