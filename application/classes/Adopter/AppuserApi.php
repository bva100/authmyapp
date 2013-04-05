<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Convert a Model_App_User object to an API data object, pre-formatted.
 *
 * @author BRIAN ANDERSON
 */
class Adopter_AppuserApi {
	
	/**
	 * Holds an instance of a Model_App_User class
	 *
	 * @var string
	 */
	private $user;
	
	/**
	 * Store vars to what object?  (stdClass)
	 *
	 * @var stdClass object
	 */
	private $api_user;
	
	/**
	 * Convert Model_App_User object to api object
	 *
	 * @param Model_App_User $user 
	 * @param stdClass $api_user
	 * @author BRIAN ANDERSON
	 */
	public function __construct(Model_App_User $user, stdClass $api_user)
	{
		$this->user = $user;
		$this->api_user = $api_user;
	}
	
	/**
	 * convert
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function convert()
	{
		$api_user = $this->api_user;
		$api_user->id = $this->user->id();
		if ($this->user->email()) 
		{
			$api_user->email = $this->user->email();
		}
		if ($this->user->first_name() OR $this->user->last_name()) 
		{
			$api_user->name = new stdClass;
			if ($this->user->first_name()) 
			{
				$api_user->name->first = $this->user->first_name();
			}
			if ($this->user->last_name()) 
			{
				$api_user->name->last = $this->user->last_name();
			}
			if ($this->user->last_name() AND $this->user->first_name()) 
			{
				$api_user->name->full = $this->user->first_name().' '.$this->user->last_name();
			}
		}
		if ($this->user->birthday())
		{
			$api_user->birthday = $this->user->birthday();
		}
		if ($this->user->gender()) 
		{
			$api_user->gender = $this->user->gender();
		}
		if ($this->user->country_code()) 
		{
			$api_user->country_code = $this->user->country_code();
		}
		if ($this->user->timezone()) 
		{
			$api_user->timezone = $this->user->timezone();
		}
		if ($this->user->ip()) 
		{
			$api_user->ip = $this->user->ip();
		}
		if ($this->user->phone())
		{
			$api_user->phone = $this->user->phone();
		}
		if ($this->user->employer_name() OR $this->user->job_title()) 
		{
			$api_user->job = new stdClass;
			if ($this->user->employer_name()) 
			{
				$api_user->job->employer = $this->user->employer_name();
			}
			if ($this->user->job_title()) 
			{
				$api_user->job->title = $this->user->job_title();
			}
		}
		if ($this->user->facebook_id()) 
		{
			$api_user->facebook = new stdClass;
			if ($this->user->facebook_id()) 
			{
				$api_user->facebook->id = $this->user->facebook_id();
			}
			if ($this->user->facebook_token()) 
			{
				$api_user->facebook->token = $this->user->facebook_token();
			}
			if ($this->user->facebook_token_expires()) 
			{
				$api_user->facebook->token_expires = $this->user->facebook_token_expires();
			}
			if ($this->user->picture()) 
			{
				$api_user->facebook->picture = $this->user->picture();
			}
		}
		if ($this->user->state()) 
		{
			$api_user->state = $this->user->state();
		}
		if ($this->user->create_timestamp()) 
		{
			$api_user->create_timestamp = $this->user->create_timestamp();
		}
		return $api_user;
	}

}
