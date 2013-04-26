<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Twitter to User (app_user) Adopter
 *
 * @author BRIAN ANDERSON
 */
class Adopter_TwitterUser {
	
	/**
	 * Titter Api
	 *
	 * @var stdObject
	 */
	private $api;
	
	/**
	 * Model_App_User object
	 *
	 * @var Model_App_User object
	 */
	private $user;
	
	/**
	 *  Constructor sets both twitter api object and user object
	 *
	 * @param string $li_data 
	 * @param Model_Abstract $user (can be Model_User or Model_App_User)
	 * @author BRIAN ANDERSON
	 */
	public function __construct(Api_Twitter $api, Model_Abstract $user)
	{
		$this->api  = $api;
		$this->user = $user;
	}
	
	/**
	 * Convert
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function convert()
	{
		if ($this->api->id()) 
		{
			$this->user->set_twitter_id($this->api->id(), TRUE);
		}
		if ($this->api->username()) 
		{
			$this->user->set_twitter_username($this->api->username(), TRUE);
		}
		if ($this->api->first_name()) 
		{
			$this->user->set_first_name($this->api->first_name(), TRUE);
		}
		if ($this->api->last_name()) 
		{
			$this->user->set_last_name($this->api->last_name(), TRUE);
		}
		if ( ! $this->user->picture() AND $this->api->picture()) 
		{
			$this->user->set_picture($this->api->picture(), TRUE);
		}
		if ($this->api->timezone()) 
		{
			$this->user->set_timezone($this->api->timezone(), TRUE);
		}
		return($this);
	}
	
	/**
	 * Update User model, use this after convert method since convert method uses lazy loading
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function update()
	{
		$this->user->db_update();
	}
	
}
