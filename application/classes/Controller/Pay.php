<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Make and manage payments
 *
 * @author BRIAN ANDERSON
 */
class Controller_Pay extends Controller_Home {
	
	public function action_plan()
	{
		$plan_id = (int) get('plan_id', 0);
		$app_id  = (int) get('app_id', 0);
		$new_app = (bool) get('new_app', FALSE);
		
		// create Model_Plan object
		$dao_plan = Factory_Dao::create('kohana', 'plan', $plan_id);
		$plan = Factory_Model::create($dao_plan);
		if ( ! $plan->id() ) 
		{
			// plan didn't load, throw exception
			throw new Exception('We cannot complete your request at this time. Please try again soon.', 1);
		}
		
		// create plan_confirm_token and set to session
		$token = md5(uniqid(mt_rand(), TRUE));
		Session::instance()->set('plan_confirm_token', $token);
		
		// create payment object. Default to wepay
		$wepay = Factory_Payment::create('wepay');
		
		// does user have a plan? If YES, cancel it
		if ($this->user()->plan_wepay_preapproval_id()) 
		{
			$cancel_response = $wepay->request('/preapproval/cancel', array('preapproval_id' => $this->user->plan_wepay_preapproval_id()));
			$this->user->set_plan_wepay_preapproval_id(0);
		}
		
		// create new preapproval
		$response = $wepay->request('preapproval/create', array(
			'account_id'        => Factory_Payment::account_id('wepay'),
			'period'            => 'monthly',
			// 'amount'            => $plan->price(),
			'amount'            => '1001',
			'mode'              => 'iframe',
			'short_description' => 'AuthMyApp subscription for user_id '.$this->user->id(),
			'callback_uri'      => URL::base(TRUE).'callback/wepayipn?type=preapproval',
			'redirect_uri'      => URL::base(TRUE).'pay/planConfirm?app_id='.$app_id.'&new_app='.$new_app.'&plan_id='.$plan_id.'&token='.urlencode($token),
			'auto_recur'        => 'true',
		));
		
		$view = new View('main/pay/preapproval');
		$view->response        = $response;
		$view->plan            = $plan;
		$view->user            = $this->user();
		$view->header          = new View('main/home/header');
		$view->header->user    = $this->user();
		$view->sidebar         = new View('main/home/sidebar');
		$view->sidebar->page   = 'payments';
		$this->template->set('content', $view);
	}
	
	public function action_planConfirm()
	{
		$preapproval_id = (int)  get('preapproval_id', 0);
		$app_id         = (int)  get('app_id', 0);
		$plan_id        = (int)  get('plan_id', 0);
		$new_app        = (bool) get('new_app', FALSE);
		$token          = (string) get('token', FALSE);
		
		// create wepay object
		$wepay = Factory_Payment::create('wepay');
		
		// validate
		if ( ! $token ) 
		{
			throw new Exception("You\'re pre-approval was not confirmed. Please try again soon", 1);
		}
		if ( $token !== Session::instance()->get('plan_confirm_token', FALSE) ) 
		{
			throw new Exception('We cannot complete your request at this time. Please contact customer support to ensure your payment goes through. '.HTML::mailto('hello@authmyapp.com?subject=payment-issue', 'Click here to email us.'), 1);
		}
		if ( ! $plan_id ) 
		{
			throw new Exception('We cannot complete your request at this time. Please contact customer support to ensure your payment goes through. '.HTML::mailto('hello@authmyapp.com?subject=payment-issue', 'Click here to email us.'), 1);
		}
		
		// check preapproval_id status and response state
		$response = $wepay->request('preapproval', array('preapproval_id' => $preapproval_id));
		if ( $response->account_id !== Factory_Payment::account_id('wepay') )
		{
			throw new Exception('We cannot complete your request at this time. Please try again soon.', 1);
		}
		if ( ! isset($response->state)) 
		{
			throw new Exception('A WePay error occurred and your payment was not processed. Please try again soon.', 1);
		}
		if ( $response->state !== 'approved' AND $response->state !== 'completed' )
		{
			throw new Exception('You\'re payment cannot be accepted at this time. Please try again soon.', 1);
		}
		
		// set new plan
		$this->user->set_plan_wepay_preapproval_id($preapproval_id);
		$this->user->set_plan_id($plan_id);
		
		// unset session var
		Session::instance()->delete('plan_confirm_token');
		
		// redirect
		if ( $app_id AND $new_app )
		{
			// create Model_App object
			$dao = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao);
			
			// create message for alert box
			$message = urlencode('The programming for '.$app->name().' has been completed and you can begin your downloads right away. Start with your Facebook Connect button.');
			
			// execute
	$this->redirect('downloads/connectButton?app_id='.$app->id().'&new_app='.TRUE.'&type=connect_facebook&message='.$message.'&message_type=info', 302);
		}
		else
		{
			$this->redirect('home/plans', 302);
		}
	}
	
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
		$wepay = Factory_Payment::create('wepay');
		
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
		
		// check wepay state
		$response = $wepay->request('checkout', array('checkout_id' => $checkout_id));
		if ( $response->account_id !== Factory_Payment::account_id('wepay') )
		{
			throw new Exception('We cannot complete your request at this time. Please try again soon.', 1);
		}
		if ( ! isset($response->state)) 
		{
			throw new Exception('A WePay error occurred and your payment was not processed. Please try again soon.', 1);
		}
		if ( $response->state !== 'authorized' AND $response->state !== 'reserved' AND $response->state !== 'captured' AND $response->state !== 'settled' )
		{
			throw new Exception('You\'re payment cannot be accepted at this time. Please try again soon.', 1);
		}
		
		// create app Model_Object
		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		
		// set facebook app vars
		$app->set_facebook_app_paid(TRUE);
		$app->set_facebook_app_checkout_id($checkout_id);
		
		// unset session var
		Session::instance()->delete('payFacebookApp_token');
		
		$message = urlencode('Thank you. Your Facebook App payment for '.$app->name().' has been received.');
		$redirect = URL::base(TRUE).'home/?message='.$message.'&message_type=success';
		$this->redirect($redirect, 302);
	}
	
}
