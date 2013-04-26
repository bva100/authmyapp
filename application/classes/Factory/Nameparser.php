<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Name Parser Factory
 *
 * @author BRIAN ANDERSON
 */
class Factory_Nameparser extends Factory_Abstract {
	
	public static function create($type = 'human_name_parser')
	{
		$type = strtolower($type);
		switch ($type) {
			case 'human_name_parser':
				require_once APPPATH.'classes/Vendor/HumanNameParser/Parser.php';
				 return new HumanNameParser_Parser(NULL);
				break;
			default:
				trigger_error('Factory_Nameparser::create() does not recognize type '.$type, E_USER_WARNING);
				break;
		}
	}
	
}
