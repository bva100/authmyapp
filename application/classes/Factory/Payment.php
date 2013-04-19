<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Payment factory
 *
 * @author BRIAN ANDERSON
 */
class Factory_Payment extends Factory_Abstract {
	
	/**
	 * Constants for Stripe defaults
	 */
	const STRIPE_PROD_SECRET = 'sk_live_taGeJih605N7S5vtB0xXiBKR';
	const STRIPE_PROD_KEY    = 'pk_live_QqG8pmYqMiBYIhogjGRIgjB0';
	//dev
	const STRIPE_DEV_SECRET = 'sk_test_itdJRyfG6En0nRc9Q6aQ0x75';
	const STRIPE_DEV_KEY    = 'pk_test_BaB59vhT1iePZ0AriSyFJ5PJ';
	
	/**
	 * Constants for WePay defaults
	 */
	const WEPAY_PROD_CLIENT_ID     = 195491; // client_id, different than account ID below
	const WEPAY_PROD_CLIENT_SECRET = '03a9b33baa';
	const WEPAY_PROD_ACCOUNT_ID    = 1751887241;
	const WEPAY_PROD_ACCESS_TOKEN  = 'PRODUCTION_08ee97e311ab0135ac8b154db63398c044d6cf621cda106e37ffbde39f403737'; // can be regenerated in wepay dashboard
	// dev
	const WEPAY_DEV_CLIENT_ID     = 153780; // client_id, different than account ID below
	const WEPAY_DEV_CLIENT_SECRET = 'da7e4ef739';
	const WEPAY_DEV_ACCOUNT_ID    = 962390730;
	const WEPAY_DEV_ACCESS_TOKEN  = 'STAGE_507c53273d506c238d9546cfe7fef217f5a1e3161c8f2b8ae634d9ed1acb86f0';
	
	/**
	 * Create a new payment engine object. 
	 *
	 * @param string $type 
	 * @param array $params (int) id, (string) secret, (string) access_token
	 * @return mixed
	 * @author BRIAN ANDERSON
	 */
	public static function create($type, array $params = array())
	{
		$type = strtolower($type);
		switch ($type) {
			case 'stripe':
				// note: stripe API is mostly static, so this simply sets api key depending on environment and return bool true or bool false
				require_once APPPATH.'classes/Vendor/stripe-php/lib/Stripe.php';
				if (Kohana::$environment !== 'prod') 
				{
					Stripe::setApiKey(self::STRIPE_DEV_SECRET);
				}
				else
				{
					Stripe::setApiKey(self::STRIPE_PROD_SECRET);
				}
				return TRUE;
				break;
			case 'wepay':
				// include the WePay sdk
				require_once APPPATH.'classes/Vendor/WePay.php';
				
				// set by account for current AuthMyApp environment
				if (Kohana::$environment !== 'prod') 
				{
					// dev and local params
					if ( ! isset($params['id'])) 
					{
						$params['id'] = self::WEPAY_DEV_CLIENT_ID;
					}
					if ( ! isset($params['secret'])) 
					{
						$params['secret'] = self::WEPAY_DEV_CLIENT_SECRET;
					}
					if ( ! isset($params['access_token'])) 
					{
						$params['access_token'] = self::WEPAY_DEV_ACCESS_TOKEN;
					}
					
					// set
					Wepay::useStaging($params['id'], $params['secret']);
					
					// return new WePay object
					return new WePay($params['access_token']);
				}
				else
				{
					// prod params
					if ( ! isset($params['id'])) 
					{
						$params['id'] = self::WEPAY_PROD_CLIENT_ID;
					}
					if ( ! isset($params['secret'])) 
					{
						$params['secret'] = self::WEPAY_PROD_CLIENT_SECRET;
					}
					if ( ! isset($params['access_token'])) 
					{
						$params['access_token'] = self::WEPAY_PROD_ACCESS_TOKEN;
					}
					
					// set
					Wepay::useProduction($params['id'], $params['secret']);
					
					//return new WePay object
					return new WePay($params['access_token']);
				}
				break;
			default:
				trigger_error('Payment type '.$type.' not recognized', E_USER_WARNING);
				break;
		}
	}
	
	/**
	 * Get the public_key of this env
	 *
	 * @param string $type 
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public static function public_key($type)
	{
		$type = strtolower($type);
		switch ($type) {
			case 'stripe':
				if (Kohana::$environment !== 'prod') 
				{
					return self::STRIPE_DEV_KEY;
				}
				else
				{
					return self::STRIPE_PROD_KEY;
				}
				break;
			default:
				trigger_error('Get public key does not recognize '.$type, E_USER_WARNING);
				break;
		}
	}
	
	/**
	 * Get the account ID associated with current AuthMyApp env
	 *
	 * @param string $type (ex: "wepay")
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public static function account_id($type)
	{
		$type = strtolower($type);
		switch ($type) {
			case 'wepay':
				if (Kohana::$environment !== 'prod') 
				{
					return self::WEPAY_DEV_ACCOUNT_ID;
				}
				else
				{
					return self::WEPAY_PROD_ACCOUNT_ID;
				}
				break;
			default:
				return 0;
				break;
		}
	}
	
}
