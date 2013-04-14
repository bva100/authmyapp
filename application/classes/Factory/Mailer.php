<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Factory for creating mailer
 *
 * @author BRIAN ANDERSON
 */
class Factory_Mailer extends Factory_Abstract {
	
	const MANDRILL_KEY = 'ZAm8cGgVRBGaXCrVz3CpoA';
	
	public static function create($type)
	{
		$type = strtolower($type);
		switch ($type) {
			case 'mandrill':
				require_once APPPATH.'classes/Vendor/mandrill-api-php/src/Mandrill.php';
				return new Mandrill(self::MANDRILL_KEY);
				break;
			
			default:
				# code...
				break;
		}
	}
	
}
