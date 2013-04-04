<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model_User interface
 *
 * @author BRIAN ANDERSON
 */
interface Interface_Model_User
{
	
	public static function create(Dao_Abstract $dao);
	public static function create_with_email(Dao_Abstract $dao, $email);
	
	public function set_email($email, $lazy = FALSE);
	public function email();
	
	public function set_first_name($first_name, $lazy = FALSE);
	public function first_name();
	
	public function set_last_name($last_name, $lazy = FALSE);
	public function last_name();
	
	public function set_picture($picture);
	public function picture();
	
	public function set_password(Hash_Base $hash_algo, $raw_password, $lazy = FALSE);
	public function set_rand_password(Hash_Base $hash_algo, $lazy = FALSE);
	public function password();
	public function password_hash_type();
	
	public function set_birthday($birthday, $lazy = FALSE);
	public function birthday();
	
	public function set_gender($gender, $lazy = FALSE);
	public function gender();
	
	public function set_country_code($country_code, $lazy = FALSE);
	public function country_code();
	
	public function set_timezone($timezone, $lazy = FALSE);
	public function timezone();
	
	public function set_ip($ip, $lazy = FALSE);
	public function ip();
	
	public function login_count();
	public function last_login();
	
	public function set_facebook_id($facebook_id, $lazy = FALSE);
	public function facebook_id();
	public function set_facebook_token($facebook_token, $lazy = FALSE);
	public function facebook_token();
	public function set_facebook_token_created($timestamp, $lazy = FALSE);
	public function facebook_token_created();
	public function set_facebook_token_expires($timestamp, $lazy = FALSE);
	public function facebook_token_expires();
	
	public function set_plan_id($plan_id, $lazy = FALSE);
	public function plan_id();
	public function plan();
	public function set_plan_wepay_preapproval_id($plan_wepay_preapproval_id, $lazy = FALSE);
	public function plan_wepay_preapproval_id();
	public function set_plan_wepay_preapproval_uri($plan_wepay_preapproval_uri, $lazy = FALSE);
	public function plan_wepay_preapproval_uri();
	
	public function add_role($role_name);
	public function remove_role($role_name);
	public function roles();
	
	public function add_organization($organization_id);
	public function remove_organization($organization_id);
	public function organizations();
	
	public function apps();
	public function app_ids();
	public function has_app_id($app_id);
	
} // END interface Interface_Model_User