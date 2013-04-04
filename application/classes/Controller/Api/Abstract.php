<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Api Controller. Abstract class. All api controllers extend this class
 *
 * @author BRIAN ANDERSON
 */
Abstract class Controller_Api_Abstract extends Controller {
	
	/**
	 * API version constants
	 */
	const CONNECT_VERSION = '0.8';
	const API_VERSION = '0.8'; // current api version
	
	/**
	 * The method in which this request was made. IE: GET, POST, DELETE, PUT
	 *
	 * @var string
	 */
	protected $method;
	
	/**
	 * The requested format. ex: json.
	 *
	 * @var string
	 */
	protected $format;
	
	/**
	 * Client's requested version. Defaults to current defined as this class' API_VERSION const. Manipulate via get.
	 *
	 * @var float
	 */
	protected $version;
	
	/**
	 * The client's user agent
	 *
	 * @var string
	 */
	protected $user_agent;
	
	/**
	 * Constructor/Before. Set method, format, version and user agent properties
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function before()
	{
		$this->set_method();
		$this->set_format();
		$this->set_version();
		$this->set_user_agent();
	}
	
	/**
	 * Set method
	 *
	 * @param array $_SERVER 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_method()
	{
		$method = strtoupper($_SERVER['REQUEST_METHOD']);
		
		switch ($method) {
			case 'GET':
				$this->method = 'GET';
				break;
			case 'POST':
				$this->method = 'POST';
				break;
			case 'DELETE':
				$this->method = 'DELETE';
				break;
			case 'PUT':
				$this->method = 'PUT';
				break;
			default:
				throw new Exception('Invalid method requested', 1);
				break;
		}
	}
	
	/**
	 * Set format based on uri extension
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_format()
	{
		$format = Request::current()->param('format');
		
		switch ($format) {
			case 'json':
				$this->format = 'json';
				break;
			case 'xml':
				$this->format = 'xml';
				break;
			default:
				throw new Exception('invalid format', 1);
				break;
		}
	}
	
	/**
	 * Set requested version. Defaults to current API version as defined in this as this class' API_VERSION const. Cast as float.
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_version()
	{
		$version = Request::current()->query('version');
		if ($version) 
		{
			$this->version = (double) $version;
		}
		else
		{
			$this->version = (double) self::API_VERSION;
		}
	}
	
	/**
	 * set user_agent
	 *
	 * @param string $user_agent
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_user_agent()
	{
		$this->user_agent = $_SERVER['HTTP_USER_AGENT'];
	}
	
	/**
	 * Formats data given client's requested version and requested format
	 *
	 * @param mixed $data 
	 * @return array . (mixed) data, (string) content_type.
	 * @author BRIAN ANDERSON
	 */
	public function format($data)
	{
		switch ($this->format) {
			case 'json':
				return array( 'data' => json_encode($data), 'content_type' => 'application/json' );	
				break;
			default:
				throw new Exception('Format not recognized');
				break;
		}
	}
	
	/**
	 * Convert an access token
	 *
	 * @param string $access_token 
	 * @return array
	 * @author BRIAN ANDERSON
	 */
	public function convert_access_token($encrypted_access_token)
	{
		if ( ! $encrypted_access_token)
		{
			throw new Exception('This API call requires a valid access_token', 1);
		}
		
		$token_array = array();
		$encrypt = Encrypt::instance();
		$access_token = $encrypt->decode($encrypted_access_token);
		$str_array = explode('_', $access_token);
		if ( ! $str_array OR empty($str_array)) 
		{
			throw new Exception('Invalid access token', 1);
		}
		$token_array['type'] = $str_array['0'];
		
		// set remaining token_array vars
		switch ($token_array['type']) {
			case 'app':
				$token_array['id'] = (int)$str_array['1'];
				$token_array['secret'] = $str_array['2'];
				break;
			default:
				throw new Exception('Invalid access token', 1);
				break;
		}
		return $token_array;
	}
	
	/**
	 * Validate converted token
	 *
	 * @param string $token_array 
	 * @return bool 
	 * @author BRIAN ANDERSON
	 */
	public function validate_access_token($dao_type, array $token_array)
	{
		if ( ! is_string($dao_type)) 
		{
			trigger_error('Validate_token expects argument 1, dao_type, to be string', E_USER_WARNING);
		}
		
		switch ($token_array['type']) {
			case 'app':
				$dao = Factory_Dao::create($dao_type, 'app', $token_array['id']);
				$app = Factory_Model::create($dao);
				if ( $app->secret() === $token_array['secret'])
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
				break;
			default:
				throw new Exception('Invalid access token.', 1);
				break;
		}
	}
	
}
