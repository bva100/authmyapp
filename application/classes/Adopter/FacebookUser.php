<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Facebook to User adopter. Can be used for Model_User or Model_User_App instances.
 *
 * @author BRIAN ANDERSON
 */
class Adopter_FacebookUser {
	
	/**
	 * Facebook data, received from PHP SDK graph 'me' call
	 *
	 * @var array
	 */
	private $fb_data;
	
	/**
	 * Can be Model_User or Model_User_App
	 *
	 * @var object
	 */
	private $user;
	
	public function __construct(array $fb_data, Model_Abstract $user)
	{
		$this->set_fb_data($fb_data);
		$this->set_user($user);
	}
	
	/**
	 * set fb_data
	 *
	 * @param array $fb_data
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_fb_data(array $fb_data)
	{
		$this->fb_data = $fb_data;
	}
	
	/**
	 * get fb_data
	 *
	 * @return array
	 * @author BRIAN ANDERSON
	 */
	public function fb_data()
	{
		return($this->fb_data);
	}
	
	/**
	 * set user
	 *
	 * @param object $user
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_user(Model_Abstract $user)
	{
		$this->user = $user;
	}
	
	/**
	 * get user
	 *
	 * @return object
	 * @author BRIAN ANDERSON
	 */
	public function user()
	{
		return($this->user);
	}
	
	/**
	 * Insert given facebook data into user data
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function convert()
	{
		if (isset($this->fb_data['id'])) 
		{
			$this->user->set_facebook_id($this->fb_data['id'], TRUE);
		}
		if (isset($this->fb_data['first_name']))
		{
			$this->user->set_first_name($this->fb_data['first_name'], TRUE)
		}
		if (isset($this->fb_data['last_name'])) 
		{
			$this->user->set_last_name($this->fb_datap['last_name'], TRUE);
		}
		if (isset($this->fb_data['birthday'])) 
		{
			$this->user->set_birthday( (int) strtotime($this->fb_data['birthday']), TRUE);
		}
		if (isset($this->fb_data['gender'])) 
		{
			$this->user->set_gender(substr($fb_data['gender'], 0, 1), TRUE);
		}
		if (isset($this->fb_data['email']))
		{
			$this->user->set_email($email, TRUE);
		}
		if (isset($this->fb_data['timezone']))
		{
			$this->user->set_timezone( (int) $this->fb_data['timezone'], TRUE)
		}
		if (isset($this->fb_data['country_code'])) 
		{
			$this->user->set_country_code(substr($this->fb_data['country_code'], 0, 1), TRUE);
		}
	}
	
	/**
	 * Update User model, user this after convert method since convert method uses lazy loading
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function update()
	{
		$this->user->db_update();
	}
	
}
