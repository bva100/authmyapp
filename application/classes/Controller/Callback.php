<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller for callbacks
 *
 * @author BRIAN ANDERSON
 */
class Controller_Callback extends Controller {
	
	public function action_stripeevent()
	{
		$body = @file_get_contents('php://input');
		$data = json_decode($body);
		Factory_Payment::create('stripe');
		
		// when on prod, only accept livemode
		if ( (Kohana::$environment === 'prod') AND ! $data->livemode)
		{
			// end silently
			die();
		}
		
		// use id and send request for stripe event
		// $event = Stripe_Event::retrieve($data->id);
		// if ( ! $event ) 
		// {
		// 	die();
		}
		
		// only subscribe to invoice.payment_failed and customer.subscription.deleted
		switch ($event->type) {
			case 'customer.subscription.deleted':
				$stripe_id = $event->data->object->customer;
				// use kohana's orm to find this user via stripe_id
				$dao_user = Factory_Dao::create('kohana', 'user')->where('stripe_id', '=', $stripe_id)->find();
				if ( $dao_user->loaded() ) 
				{
					// create Model_User object and set plan to free
					$user = Factory_Model::create($dao_user);
					// if users plan is not currently set to free, place on hold and set to free
					if ($user->plan_id() !== 1) 
					{
						$user->set_plan_id(1);
						$user->set_plan_state(Model_User::PLAN_STATE_PAYMENT_HOLD);
					}
				}
				// send email to user informing them that AuthMyApp cannot charge the current card on file and that they will not get new data transfers
				
				break;
			case 'invoice.payment_failed':
				// set user plan state to PLAN_STATE_OVERDUE
				$stripe_id = $data->data->object->customer;
				Kohana::$log->add(Log::ERROR, "invoice failed, stripe id is $stripe_id");
				// use kohana's orm to find this user via stripe_id
				$dao_user = Factory_Dao::create('kohana', 'user')->where('stripe_id', '=', $stripe_id)->find();
				if ( $dao_user->loaded() ) 
				{
					// create Model_User object and set plan to free
					$user = Factory_Model::create($dao_user);
					// if users plan is not free, set plan state to overdue
					if ($user->plan_id() !== 1) 
					{
						$user->set_plan_state( Model_User::PLAN_STATE_OVERDUE );
					}
				}
				// send email to user prompting them to update payment method to avoid a data transfer hold
				
				
				break;
			default:
				break;
		}
		
	}
	
	public function action_wepayipn()
	{
		$type      = (string) get('type', '');
		$wepay = Factory_Payment::create('wepay');
		
		switch ($type) {
			case 'preapproval':
				// we can receive preapproval_ids OR checkout_ids here
				$preapproval_id = (int) post('preapproval_id', 0);
				$checkout_id    = (int) post('checkout_id', 0);
				
				if ($preapproval_id)
				{
					// execute preapproval request and check response
					$response = $wepay->request('preapproval', array('preapproval_id' => $preapproval_id));
					if ( ! isset($response->state)) 
					{
						throw new Exception('A WePay error occurred and your payment was not processed. Please try again soon.', 1);
					}
					if ( $response->state !== 'approved' AND $response->state !== 'completed' )
					{
						// use kohana's orm to create dao with approval and update plan_state to payment hold
						$dao_user = ORM::factory('user')->where('plan_wepay_preapproval_id', '=', $preapproval_id)->find();
						if ($dao_user->loaded() ) 
						{
							$user = Factory_Model::create($dao_user);
							$user->set_plan_state( Model_User::PLAN_STATE_PAYMENT_HOLD );
						}
					}
				}
				else if ($checkout_id)
				{
					// execute checkout request and check response
					$response = $wepay->request('checkout', array('checkout_id' => $checkout_id));
				}
				
				break;
			default:
				break;
		}
	}
	
}
