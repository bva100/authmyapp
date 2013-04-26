<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model App User interface
 *
 * @author BRIAN ANDERSON
 */
interface Interface_Model_App_User
{
	public static function create_with_email_and_app_id(Dao_Abstract $dao, $email, $app_id);
	public static function create(Dao_Abstract $dao);
	
	public static function exists(Dao_Abstract $dao, $email, $app_id);
	
	public function set_app_id($app_id, $lazy = FALSE);
	public function app_id();
	
	public function set_first_name($first_name, $lazy = FALSE);
	public function first_name();
	public function set_last_name($first_name, $lazy = FALSE);
	public function last_name();
	
	public function set_email($email, $lazy = FALSE);
	public function email();
	
	public function set_picture($picture);
	public function picture();
	
	public function set_employer_name($employer_name, $lazy = FALSE);
	public function employer_name();
	public function set_job_title($job_title, $lazy = FALSE);
	public function job_title();
	
	public function set_phone($phone, $lazy = FALSE);
	public function phone();
	
	public function set_country_code($country_code, $lazy = FALSE);
	public function country_code();
	
	public function set_gender($gender, $lazy = FALSE);
	public function gender();
	
	public function set_ip($ip, $lazy = FALSE);
	public function ip();
	
	public function set_facebook_id($facebook_id, $lazy = FALSE);
	public function facebook_id();
	public function set_facebook_token($facebook_token, $lazy = FALSE);
	public function facebook_token();
	public function set_facebook_token_created($timestamp, $lazy = FALSE);
	public function facebook_token_created();
	public function set_facebook_token_expires($timestamp, $lazy = FALSE);
	public function facebook_token_expires();
	
	public function set_linkedin_id($linkedin_id, $lazy = FALSE);
	public function linkedin_id();
	public function set_linkedin_token($linkedin_token, $lazy = FALSE);
	public function linkedin_token();
	public function set_linkedin_token_created($timestamp, $lazy = FALSE);
	public function linkedin_token_created();
	public function set_linkedin_token_expires($timestamp, $lazy = FALSE);
	public function linkedin_token_expires();
	
	public function set_twitter_id($twitter_id, $lazy = FALSE);
	public function twitter_id();
	public function set_twitter_username($twitter_username, $lazy = FALSE);
	public function twitter_username();
	public function set_twitter_oauth_token($twitter_oauth_token, $lazy = FALSE);
	public function twitter_oauth_token();
	public function set_twitter_oauth_token_secret($twitter_oauth_token_secret, $lazy = FALSE);
	public function twitter_oauth_token_secret();
	
	public function count_logins($min_timestamp, $max_timestamp, array $options = array());
	public function record_login(Dao_Abstract $dao);
	
} // END interface Model_App_User