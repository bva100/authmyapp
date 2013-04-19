<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Make and manage payments
 *
 * @author BRIAN ANDERSON
 */
class Controller_Pay extends Controller_Home {
	
	public function action_planStripeProcess()
	{
		$stripeToken   = (string) post('stripeToken', '');
		$plan_id       = (int) post('plan_id', 0);
		$app_id        = (int) post('app_id', 0);
		$new_app       = (bool) post('new_app', FALSE);
		$payment_token = post('payment_token', FALSE);
		$coupon_code   = (string) post('coupon_code', '');
		
		// set stripe tokens
		Factory_Payment::create('stripe');
		
		// validate
		if ( ! $plan_id )
		{
			throw new Exception('We cannot complete your request at this time, please try again soon. <a href="/home/plans">Return Here</a>.');
		}
		if ( $app_id AND ! $this->user->has_app_id($app_id) )
		{
			throw new Exception("Access Denied. You do not have access to this app", 1);
		}
		if ( ! $payment_token ) 
		{
			throw new Exception('Access Denied. Invalid payment token.', 1);
		}
		if ( $payment_token !== Session::instance()->get('payment_token', FALSE) ) 
		{
			throw new Exception('Access Denied. Invalid payment token.', 1);
		}
		// unset session payment token
		Session::instance()->delete('payment_token');
		
		// create plan object
		$dao = Factory_Dao::create('kohana', 'plan', $plan_id);
		$plan = Factory_Model::create($dao);
		
		// same plan selected, redirect
		if ( $plan->id() === $this->user->plan_id() )
		{
			$this->redirect('/home/plans?app_id='.$app_id, 302);
		}
		
		// if stripe token was passed, create new stripe user with stripeToken
		if ($stripeToken) 
		{
			// if user passed token...
			if ($coupon_code) 
			{
				// create stripe customer with coupon
				$customer = Stripe_Customer::create(array(
					'card'   => $stripeToken,
					'plan'   => (string) $plan_id,
					'email'  => $this->user->email(),
					'coupon' => $coupon_code,
				));
			}
			else
			{
				// create stripe customer
				$customer = Stripe_Customer::create(array(
					'card'   => $stripeToken,
					'plan'   => (string) $plan_id,
					'email'  => $this->user->email(),
				));	
			}
			// set stripe_id in db and set plan
			$this->user->set_stripe_id($customer->id);
			$this->user->set_plan_id($plan_id);
			$this->user->set_plan_state( Model_User::PLAN_STATE_ACTIVE );
			
			// redirect to new app flow
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
				// redirect back to plan
				$dao_plan = Factory_Dao::create('kohana', 'plan', $plan_id);
				$plan = Factory_Model::create($dao);
				$message = urlencode('Thank you. Your plan is now '.$plan->name().'.');
				$this->redirect('home/plans?message='.$message.'&message_type=success', 302);
			}
		}
		else
		{
			// free plan
			if ( $plan->id() === 1 )
			{
				if ( $this->user->stripe_id() )
				{
					// cancel plan from something better than free to free
					$cu = Stripe_Customer::retrieve ($this->user->stripe_id() );
					$cu->cancelSubscription();
					$this->user->set_plan_id(1);
					$this->user->set_plan_state( Model_User::PLAN_STATE_ACTIVE );
					$message = urlencode('Your plan has been successfully canceled.');
					$this->redirect('home/plans?message='.$message.'&message_type=success', 302);
				}
				else
				{
					$this->user->set_plan_id(1);
					$this->user->set_plan_state( Model_User::PLAN_STATE_ACTIVE );
					// redirect to free plan prompt
					if ($app_id AND $new_app )
					{
						$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
						$app = Factory_Model::create($dao_app);
						$message = urlencode( $app->name().' is ready to go. Be sure to click on the help link in the navigation bar for API integration tutorials.');
						$this->redirect('home?message='.$message.'&alert_type=success', 302);
					}
					else
					{
						// not sure when this would happen, but it is here just in case
						$this->redirect('home/plans', 302);
					}
				}
			}
			
			// change to new stripe plan. if coupon exists, apply
			$c = Stripe_Customer::retrieve( $this->user->stripe_id() );
			if ($coupon_code) 
			{
				$c->updateSubscription( array( 'plan' => (string) $plan_id, 'coupon' => $coupon_code ) );
			}
			else
			{
				$c->updateSubscription( array("plan" => (string) $plan_id ) );
			}
			// update db, do not update plan state
			$this->user->set_plan_id($plan_id);
			// redirect
			$dao_plan = Factory_Dao::create('kohana', 'plan', $plan_id);
			$plan = Factory_Model::create($dao_plan);
			// message, switch on state
			if ($this->user->plan_state() !== Model_User::PLAN_STATE_ACTIVE ) 
			{
				$message = urlencode('Your plan has been successfully changed to '.$plan->name().' however, you\'ll still have to update your credit card to proceed.');
			}
			else
			{
				$message = urlencode('Your plan has been successfully changed to '.$plan->name());
			}
			$this->redirect('home/plans?message='.$message.'&message_type=success', 302);
		}
	}
	
	public function action_changeStripeCc()
	{
		$pk = Factory_Payment::public_key('stripe');
		$token = md5(uniqid(mt_rand(), TRUE));
		Session::instance()->set('change_stripe_cc_token', $token);
		
		$view = new View('main/pay/stripe/changecc');
		$view->pk = $pk;
		$view->token = $token;
		$view->header = new View('main/home/header');
		$view->header->user = $this->user;
		$view->footer = new View('footer');
		$this->template->set('content', $view);
	}
	
	public function action_changeStripeCcProcess()
	{
		$token      = (string) post('token', FALSE);
		$stripeToken = (string) post('stripeToken', '');
		
		Factory_Payment::create('stripe');
		
		if ( ! $token OR ! $stripeToken) 
		{
			throw new Exception('Cannot complete credit card update: invalid token', 1);
		}
		if ( $token !== Session::instance()->get('change_stripe_cc_token', FALSE) )
		{
			throw new Exception('Cannot complete credit card update: invalid token', 1);
		}
		Session::instance()->delete('change_stripe_cc_token');
		
		// update stripe credit card
		$cu = Stripe_Customer::retrieve($this->user->stripe_id());
		$cu->card = $stripeToken;
		$cu->save();
		
		// change state plan
		$this->user->set_plan_state( Model_User::PLAN_STATE_ACTIVE );
		
		// redirect
		$message = urlencode('Thank you. Your credit card was successfully updated.');
		$this->redirect('home?message='.$message.'&message_type=success', 302);
	}
	
	public function action_validateStripeCoupon()
	{
		$coupon_id = (string) post('coupon_code', '');
		Factory_Payment::create('stripe');
		$this->auto_render = FALSE;
		try
		{
			Stripe_Coupon::retrieve( $coupon_id );
			echo 'valid';
		}
		catch(Exception $e) 
		{
			// Since it's a decline, Stripe_CardError will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			echo $err['message'];
		}
	}
	
	public function action_wepayplan()
	{
		die('currently, not in use');
		
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
			'amount'            => $plan->price(),
			'start_time'        => time(),
			'mode'              => 'iframe',
			'short_description' => 'AuthMyApp subscription for user_id '.$this->user->id(),
			'callback_uri'      => URL::base(TRUE).'callback/wepayipn?type=preapproval',
			'redirect_uri'      => URL::base(TRUE).'pay/planConfirm?app_id='.$app_id.'&new_app='.$new_app.'&plan_id='.$plan_id.'&token='.urlencode($token),
			'auto_recur'        => TRUE,
		));
		
		$view = new View('main/pay/preapproval');
		$view->response        = $response;
		$view->plan            = $plan;
		$view->user            = $this->user();
		$view->header          = new View('main/home/header');
		$view->header->user    = $this->user();
		$view->sidebar         = new View('main/home/sidebar');
		$view->sidebar->page   = 'payments';
		$view->footer          = new View('footer');
		$this->template->set('content', $view);
	}
	
	
	public function action_WePayplanConfirm()
	{
		die('currently, not in use');
		
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
			throw new Exception('We cannot complete your request at this time. Please contact customer support to ensure your payment goes through. '.HTML::mailto('support@authmyapp.com?subject=payment-issue', 'Click here to email us.'), 1);
		}
		if ( ! $plan_id ) 
		{
			throw new Exception('We cannot complete your request at this time. Please contact customer support to ensure your payment goes through. '.HTML::mailto('support@authmyapp.com?subject=payment-issue', 'Click here to email us.'), 1);
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
	
	public function action_WePayfacebookApp()
	{
		die('currently, not in use');
		
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
		die('currently, not in use');
		
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
