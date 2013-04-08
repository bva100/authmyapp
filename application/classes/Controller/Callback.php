<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller for callbacks
 *
 * @author BRIAN ANDERSON
 */
class Controller_Callback extends Controller {
	
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
