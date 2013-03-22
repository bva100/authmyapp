<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Sender for Facebooks script
 *
 * @author BRIAN ANDERSON
 */
class Script_Sender_Facebook extends Script_Abstract{
	
	public function set_file_data()
	{
		$this->file_data = '
session_start();
$_SESSION["authMyAppSecurityToken"] = md5(uniqid(mt_rand(), TRUE));
		'
	}
	
}
