<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Coupon controller, for discounts and deals and such
 *
 * @author BRIAN ANDERSON
 */
class Controller_Coupon extends Controller_Welcome {
	
	public function before()
	{
		parent::before();
		$this->add_css('bootstrap/font-awesome.min');
		$this->add_flat_ui();
		$this->add_css('main/coupon/index');
	}
	
	public function add_flat_ui()
	{
		$this->add_js('bootstrap/flat-ui/application');
		$this->add_js('bootstrap/flat-ui/custom_checkbox_and_radio');
		$this->add_js('bootstrap/flat-ui/custom_radio');
		$this->add_js('bootstrap/flat-ui/html5shiv');
		$this->add_js('bootstrap/flat-ui/icon-font-ie7');
		$this->add_js('bootstrap/flat-ui/jquery-ui-1.10.0.custom.min');
		$this->add_js('bootstrap/flat-ui/jquery.dropkick-1.0.0');
		$this->add_js('bootstrap/flat-ui/jquery.placeholder');
		$this->add_js('bootstrap/flat-ui/jquery.tagsinput');
		$this->add_js('bootstrap/flat-ui/lte-ie7-24');
		$this->add_css('bootstrap/flat-ui');
	}
	
	public function set_view_props($view_string)
	{
		$this->set_view( new View($view_string) );
		// isset($this->user) ? $this->set_view_header('main/home/header') : $this->set_view_header('main/welcome/header');
		// $this->set_view_sidebar('main/help/sidebar');
		// $this->set_view_footer('footer');
	}
	
	public function action_index()
	{
		$coupon_token = md5(uniqid(mt_rand(), TRUE));
		Session::instance()->set('coupon_token', $coupon_token);
		
		$this->set_view_props('main/coupon/index');
		$this->view->user = $this->user;
		$this->view->coupon_token = $coupon_token;
		$this->view->tweet_params = $tweet_params = 'url='.URL::base(TRUE).'&text='.urlencode("@AuthMyApp makes it easy to setup Social Connect buttons for your app or website. Check 'em out at").'&related=authMyApp&lang=en&dnt=true';
		$this->set_temp_view();
		$this->add_js('main/coupon/index');
	}
	
	public function action_getCode()
	{
		$coupon_token = (string) get('coupon_token', FALSE);
		$type = (string) get('type', '');
		
		// validate coupon token
		if ( ! $coupon_token) 
		{
			die('no coupon_token found');
		}
		else if ($coupon_token !== Session::instance()->get('coupon_token', FALSE))
		{
			die('invalid coupon_token');
		}
		
		switch ($type) {
			case 'first_month_high':
				$code = 'LikeTweetMeMaybe';
				break;
			default:
				$code = FALSE;
				break;
		}
		$this->auto_render = FALSE;
		$this->response->body($code);
	}
	
	public function action_validateAccess()
	{
		// $this->auto_render = FALSE;
	}

}
