<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Interface for Model_Notification
 *
 * @author BRIAN ANDERSON
 */
interface Interface_Model_Notification
{
	public static function create_with_user_and_type(Dao_Abstract $dao, Model_User $user, $type);
	
	// public function add_messenger(Messenger_Abstract $messenger);
	// public function remove_messenger()
	// public function messengers();
	// public function send();
	// 
	// public function set_user_id($user_id);
	// public function user_id();
	// 
	// public function set_type($type);
	// public function type();
	// 
	// public function set_message($message);
	// public function message();
	// 
	// public function set_link($link);
	// public function link();
	
} // END interface Interface_Model_Notification