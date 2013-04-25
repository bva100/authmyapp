<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Linked In to User Adopter
 *
 * @author BRIAN ANDERSON
 */
class Adopter_LinkedinUser {
	
	/**
	 * LinkedIn Profile data received from using profile call
	 *
	 * @var stdObject
	 */
	private $li_data;
	
	/**
	 * Model_App_User object
	 *
	 * @var Model_App_User object
	 */
	private $user;
	
	/**
	 * LI data
	 *
	 * @param string $li_data 
	 * @param Model_Abstract $user (can be Model_User or Model_App_User)
	 * @author BRIAN ANDERSON
	 */
	public function __construct(stdClass $li_data, Model_Abstract $user)
	{
		$this->li_data = $li_data;
		$this->user    = $user;
	}
	
	/**
	 * Convert
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function convert()
	{
		if (isset($this->li_data->emailAddress)) 
		{
			$this->user->set_email($this->li_data->emailAddress, TRUE);
		}
		if (isset($this->li_data->firstName)) 
		{
			$this->user->set_first_name($this->li_data->firstName, TRUE);
		}
		if (isset($this->li_data->lastName)) 
		{
			$this->user->set_last_name($this->li_data->lastName, TRUE);
		}
		if (isset($this->li_data->id)) 
		{
			$this->user->set_linkedin_id($this->li_data->id, TRUE);
		}
		if (isset($this->li_data->location->country->code)) 
		{
			$this->user->set_country_code($this->li_data->location->country->code);
		}
		if (isset($this->li_data->pictureUrl) AND ! $this->user->picture()) 
		{
			// only add if user does not already have picture. This gives preference to other picture sources.
			$this->user->set_picture($this->li_data->pictureUrl, TRUE);
		}
		if (isset($this->li_data->positions) AND isset($this->li_data->positions->values['0'])) 
		{
			$this->user->set_employer_name( $this->li_data->positions->values['0']->company->name, TRUE );
			$this->user->set_job_title( $this->li_data->positions->values['0']->title, TRUE );
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
