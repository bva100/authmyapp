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
<?php
// start session. Lazy load in case environment uses auto session
if ( ! session_id() ) 
{
	session_start();
}

// set GET vars
if (isset($_GET["button_version"])) 
{
	$button_version = $_GET["button_version"];
}
else
{
	$button_version = 0;
}

// create and set security_token
$security_code = md5(uniqid(mt_rand(), TRUE));
$_SESSION["authMyAppSecurityToken"] = $security_code;

// redirect
header( "Location: '.URL::base(TRUE).'connect_facebook?app_id='.$this->app_id().'&security_code=$security_code&connect_version='.Controller_Api::CONNECT_VERSION.'" );

		';
	}
	
}
