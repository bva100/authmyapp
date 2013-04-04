<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User API controller
 *
 * @author BRIAN ANDERSON
 */
class Controller_Api_Users extends Controller_Api_Abstract {
	
	/**
	 * Id of app
	 *
	 * @var int
	 */
	private $app_id;
	
	/**
	 * App secret
	 *
	 * @var string
	 */
	private $app_secret;
	
	/**
	 * Get a specific user's data. Only accepts get requests. Requires a valid app access token.
	 *
	 * @param integer $user_id
	 * @return stdObject
	 */
	public function action_index()
	{
		$this->set_version();
		$this->response->body('get a specific users data here. Only accepts get requests');
	}
	
	/**
	 * Get the AuthMyApp user_id and email of all users for this app. Only accepts get requests. Requires a valid app access token.
	 *
	 * @param integer $offset
	 * @param integer $limit. default is 50.
	 * @return void
	 */
	public function action_all()
	{
		$this->response->body('get a dictionary/associative array associated with all users for this app. Only accepts get requests.');
	}
	
	/**
	 * Search for a user with given params. Only accepts get requests. Requires a valid app access token.
	 *
	 * @param string $email
	 * @param integer $offset
	 * @param integer $limit. default is 50.
	 * @return void
	 */
	public function action_search()
	{
		$this->response->body('search for a user with given params. Only accepts get requests.');
	}
	
}
