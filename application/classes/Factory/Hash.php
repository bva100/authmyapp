<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Creates a Hash decorator object
 *
 * @author BRIAN ANDERSON
 */
class Factory_Hash extends Factory_Abstract {
	
	public static function create(Hash_Abstract $hash_algo)
	{
 		return new Hash_Base($hash_algo);
	}
	
	public static function create_via_type($type)
	{
		if ( ! is_string($type)) 
		{
			trigger_error('create_via_type expects argument 1, type, to be string', E_USER_WARNING);
		}
		
		switch ($type) {
			case 'kohana_auth':
				$hash_algo = auth::instance();
				return self::create($hash_algo);
				
				break;
			default:
				break;
		}
	}
	
}
