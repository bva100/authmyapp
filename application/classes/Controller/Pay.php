<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Make and manage payments
 *
 * @author BRIAN ANDERSON
 */
class Controller_Pay extends Controller_Home {
	
	public function action_facebookApp()
	{
		$app_id = (int) get('app_id', 0);
		$wepay = Factory_Payment::create('wepay');
		$payFacebookApp_token = md5(uniqid(mt_rand(), TRUE));
		
		// set token to session
		Session::instance()->set('payFacebookApp_token', array( 'token' => $payFacebookApp_token, 'app_id' => $app_id) );
		
		// check access
		if ( ! $this->user->has_app_id($app_id) )
		{
			throw new Exception('Access Denied. You cannot make a payment for this app at this time.', 1);
		}
		
		// create a checkout
		$response = $wepay->request('checkout/create', array(
			'account_id'        => Factory_Payment::account_id('wepay'),
			'amount'            => '25.00',
			'short_description' => 'Service charge for creating Facebook App and Custom dialog for app id '.$app_id,
			'type'              => 'SERVICE',
			'redirect_uri'      => URL::base(TRUE).'/pay/facebookAppProcess?payFacebookApp_token='.$payFacebookApp_token.'&app_id='.$app_id,
			'mode'              => 'iframe',
		));
		
		if ( ! isset($response->checkout_uri) OR ! $response->checkout_uri) 
		{
			throw new Exception("We cannot process your request at this time. Please try again soon.", 1);
		}
		
		$view = new View('main/pay/index');
		$view->response      = $response;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'payments';
		$this->template->set('content', $view);
	}
	
	public function action_facebookAppProcess()
	{
		$app_id                       = (int) get('app_id', 0);
		$checkout_id                  = (int) get('checkout_id', '');
		$payFacebookApp_token         = (string) get('payFacebookApp_token', '');
		$payFacebookApp_token_session = Session::instance()->get('payFacebookApp_token', array());
		
		// validate
		if ( ! $checkout_id) 
		{
			throw new Exception('We cannot process your request at this time. Please try again soon.', 1);
		}
		if ( ! isset($payFacebookApp_token_session['token']) OR ! isset($payFacebookApp_token_session['app_id']))
		{
			throw new Exception('Token not valid. Please try again', 1);
		}
		if ( $payFacebookApp_token !== $payFacebookApp_token_session['token'] )
		{
			throw new Exception('Token not valid. Please try again.');
		}
		if ( $payFacebookApp_token_session['app_id'] !== $app_id )
		{
			throw new Exception('Invalid App Id. Please try again soon', 1);
		}
		if ( ! $this->user->has_app_id($app_id) )
		{
			throw new Exception('Access Denied. You cannot make a payment for this app at this time.', 1);
		}
		
		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		$app->set_facebook_app_paid(TRUE);
		$app->set_facebook_app_checkout_id($checkout_id);
		
		$message = urlencode('Thank you. Your Facebook App payment for '.$app->name().' has been received.');
		$redirect = URL::base(TRUE).'home/?message='.$message.'&message_type=success';
		$this->redirect($redirect, 302);
	}
	
}
