<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User API controller
 *
 * @author BRIAN ANDERSON
 */
class Controller_Api_Users extends Controller_Api_Abstract {
	
	/**
	 * App created from token used in requested. Is validated.
	 *
	 * @var Model_App object
	 */
	private $app;
	
	/**
	 * Constructor/before. run parent before methods, validate access token, set app properties
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function before()
	{
		parent::before();

		// validate access token
		if ( isset($_REQUEST['access_token'])) 
		{
			$encrypted_access_token = $_REQUEST['access_token'];
		}
		else
		{
			throw new Exception('An access token is required for this API call', 1);
		}
		$token_array = $this->convert_access_token($encrypted_access_token);
		if ( ! $this->validate_access_token('kohana', $token_array) ) 
		{
			throw new Exception('Invalid access token', 1);
		}
		
		// set app property
		$dao = Factory_Dao::create('kohana', 'app', $token_array['id']);
		$app = Factory_Model::create($dao);
		$this->app = $app;
	}
	
	/**
	 * Get a specific user's data. Only accepts get requests. Requires a valid app access token.
	 *
	 * @param integer $user_id
	 * @return stdObject
	 */
	public function action_index()
	{
		$user_id = (int) get('user_id', 0);
		if ( ! $user_id) 
		{
			throw new Exception('This API call requires a user_id parameter to be passed', 1);
		}
		
		// create Model_App_User object and esnure this user belongs to this app
		$dao = Factory_Dao::create('kohana', 'app_user', $user_id)->where('app_id', '=', $this->app->id());
		$user = Factory_Model::create($dao);

		// convert to api_user with adopter and format
		$adopter = Factory_Adopter::create('appuser_to_api', $user, new stdClass());
		$api_user = $adopter->convert();
		$data_array = $this->format($api_user);
		
		//output
		$this->response->headers('Content-Type', $data_array['content_type']);
		$this->response->body($data_array['data']);
	}
	
	/**
	 * Get an array of user objects associated with the app. only accepts get requests. Requires a valid app access token
	 *
	 * @param integer $offset
	 * @param integer $limit. default is 50.
	 * @return array
	 */
	public function action_all()
	{
		$offset = (int) get('offset', 0);
		$limit =  (int) get('limit', 50);
		
		$model_array = array();
		$api_array = array();
		$daos = Factory_Dao::create('kohana', 'app_user')
			->where('app_id', '=', $this->app->id())
			->offset($offset)
			->limit($limit)
			->find_all();
		foreach ($daos as $dao) 
		{
			$model_array[] = Factory_Model::create($dao);
		}
		
		//convert
		foreach ($model_array as $model_app_user) 
		{
			$adopter = Factory_Adopter::create('appuser_to_api', $model_app_user, new stdClass());
			$api_array[] = $adopter->convert();
		}
		$results = $this->format($api_array);
		
		$this->response->headers('Content-Type', $results['content_type']);
		$this->response->body($results['data']);
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
		$email  = (string ) get('email', '');
		$offset = (int) get('offset', 0);
		$limit  = (int) get('limit', 0);
		
		
	}
	
}
