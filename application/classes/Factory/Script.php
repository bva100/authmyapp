<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Script Factory. Set 'type' (ex: 'connect_facebook'), user, app and an array of parameters called data.
 * If compression is desired, call set_compression_type of returned object
 * Returned object's output methods include: create(), create_text(), url()
 *
 * @author BRIAN ANDERSON
 */
class Factory_Script extends Factory_Abstract {
	
	public static function create($type, Model_User $user, Model_App $app, array $data)
	{
		switch ($type) {
			case 'connect_facebook_button':
			case 'login_facebook_button':
				return new Script_Connect_Button_Facebook($user, $app, $data);
				break;
			case 'sender':
				return new Script_Sender_Facebook($user, $app, $data);
			case 'receiver':
				return new Script_Receiver($user, $app, $data);
			default:
				trigger_error('Factory_Script::create() does not recognize type '.$type, E_USER_WARNING);
				break;
		}
		
	}
	
}
