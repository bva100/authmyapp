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
	
	public function set_email($email);
	public function email();
	
	public function set_facebook_id($facebook_id, $lazy = FALSE);
	public function facebook_id();
	
	public function set_first_name($first_name, $lazy = FALSE);
	public function first_name();
	
	public function set_last_name($last_name, $lazy = FALSE);
	public function last_name();
	
	// public function set_password(Hash_Algo_Abstract $hash_algo, $raw_password, $lazy = FALSE);
	// public function set_rand_password();
	// public function password();
	
} // END interface Interface_Model_User