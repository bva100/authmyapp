<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Payment factory
 *
 * @author BRIAN ANDERSON
 */
class Factory_Payment extends Factory_Abstract {
	
	/**
	 * Constants for wepay defaults
	 */
	const WEPAY_PROD_CLIENT_ID     = 195491; // client_id, different than account ID below
	const WEPAY_PROD_CLIENT_SECRET = '03a9b33baa';
	const WEPAY_PROD_ACCOUNT_ID    = 1751887241;
	const WEPAY_PROD_ACCESS_TOKEN  = 'PRODUCTION_08ee97e311ab0135ac8b154db63398c044d6cf621cda106e37ffbde39f403737'; // can be regenerated in wepay dashboard
	// dev
	const WEPAY_DEV_CLIENT_ID     = 153780;// client_id, different than account ID below
	const WEPAY_DEV_CLIENT_SECRET = 'da7e4ef739';
	const WEPAY_DEV_ACCOUNT_ID    = 962390730;
	const WEPAY_DEV_ACCESS_TOKEN  = 'STAGE_507c53273d506c238d9546cfe7fef217f5a1e3161c8f2b8ae634d9ed1acb86f0';
	
	/**
	 * Create a new payment engine object. 
	 *
	 * @param string $type 
	 * @param array $params (int) id, (string) secret, (string) access_token
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function create($type, array $params = array())
	{
		$type = strtolower($type);
		switch ($type) {
			case 'wepay':
			default:
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
