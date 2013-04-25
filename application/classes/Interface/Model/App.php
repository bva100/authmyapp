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
	
	public function set_access_token($lazy = FALSE);
	public function access_token();
	
	public function set_organization_id($organization_id, $lazy = FALSE);
	public function organization_id();
	
	public function set_primary_user_id($primary_user_id, $lazy = FALSE);
	public function primary_user_id();
	
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
	
	public function set_post_auth_uri($post_auth_uri, $lazy = FALSE);
	public function post_auth_uri();
	public function post_auth_url();
	
	public function set_delivery_method($delivery_method, $lazy = FALSE);
	public function delivery_method($text = FALSE);
	
	public function set_storage_method($storage_method, $lazy = FALSE);
	public function storage_method();
	
	public function set_salt($lazy = FALSE);
	public function salt();
	
	public function set_picture_width($picture_width, $lazy = FALSE);
	public function picture_width();
	public function set_picture_height($picture_height, $lazy = FALSE);
	public function picture_height();
	
	public function set_facebook_app_paid($facebook_app_paid, $lazy = FALSE);
	public function facebook_app_paid();
	public function set_facebook_app_checkout_id($facebook_app_checkout_id, $lazy = FALSE);
	public function facebook_app_checkout_id();
	
	public function set_facebook_app_id($facebook_app_id, $lazy = FALSE);
	public function facebook_app_id();
	public function set_facebook_secret($facebook_secret, $lazy = FALSE);
	public function facebook_secret();
	public function facebook_config();
	
	public function set_linkedin_key($key, $lazy = FALSE);
	public function linkedin_key();
	public function set_linkedin_secret($secret, $lazy = FALSE);
	public function linkedin_secret();
	
	public function app_users();
	
	public function count_logins($min_timestamp, $max_timestamp, array $options = array());
	public function count_signups($min_timestamp, $max_timestamp, array $options = array());
	
} // END interface Interface_Model_App