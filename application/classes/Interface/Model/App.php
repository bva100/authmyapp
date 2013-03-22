<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model_App interface
 *
 * @author BRIAN ANDERSON
 */
interface Interface_Model_App
{
	public static function create_with_name_and_organization_id(Dao_Abstract $dao, $name, $organization_id);
	public static function create(Dao_Abstract $dao);
	
	public static function exists(Dao_Abstract $dao, $name, $organization_id);
	
	public function set_secret($lazy = FALSE);
	public function secret();
	
	public function set_organization_id($organization_id, $lazy = FALSE);
	public function organization_id();
	
	public function set_name($name, $lazy = FALSE);
	public function name();
	
	public function set_domain($domain, $lazy = FALSE);
	public function domain();
	
	public function set_sender_uri($sender_uri, $lazy = FALSE);
	public function sender_uri();
	public function sender_url();
	
	public function set_receiver_uri($receiver_uri, $lazy = FALSE);
	public function receiver_uri();
	public function receiver_url();
	
	public function set_delivery_method($delivery_method, $lazy = FALSE);
	public function delivery_method();
	
	public function set_salt($lazy = FALSE);
	
	
	public function set_picture_width($picture_width, $lazy = FALSE);
	public function picture_width();
	public function set_picture_height($picture_height, $lazy = FALSE);
	public function picture_height();
	
	public function set_facebook_app_id($facebook_app_id, $lazy = FALSE);
	public function facebook_app_id();
	public function set_facebook_secret($facebook_secret, $lazy = FALSE);
	public function facebook_secret();
	public function facebook_config();
	
} // END interface Interface_Model_App