<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Create a new Api Exception. Does not extend core Exception class due to kohana's nutty stack trace. If there were a way to override kohana exceptions, we could once again extend Exception, as this class should.
 *
 * @author BRIAN ANDERSON
 */
class ApiException {

	/**
	 * Create new ApiException object. pass api code (defined in abstract api class) or class first param as null and set message, http status code and AuthMyApp code and learn more uri into options array
	 *
	 * @param string $code 
	 * @param string $format
	 * @param array $options 
	 * @author BRIAN ANDERSON
	 */
	public function __construct($code, $format, array $options = array()) {
		$data = array();		
		$data['error_code'] = $code;
		$data['more_info'] = URL::base(TRUE).'api/docs/error/'.$code;
		
		switch ($code) {
			case 400:
				$data['error_type']       = 'Param Error';
				$data['message']          = 'A required parameter is missing or is malformed. Be sure to add the api version parameter (v), an acess token if needed (access_token), and any other required parameters for this resource.';
				ksort($data);
				$this->send_output($data, 400);
				break;
			case 401:
				$data['error_type']       = 'Invalid Auth';
				$data['message']          = 'Please ensure you have passed a valid access token parameter.';
				ksort($data);
				$this->send_output($data, 401);
				break;
			case 403:
				$data['error_type']       = 'Not Authorized';
				$data['message']          = 'Authentication was successful, however the client does not have access to the information requested. Although this error can occur for many reasons, it often occurs when the client has exceeded his or her rate limit for this hour or if the client\'s last payment was invalid';
				ksort($data);
				$this->send_output($data, 403);
				break;
			case 404:
				$data['error_type']       = 'Resource Does Not Exit';
				$data['message']          = 'The requested path does not exit.';
				ksort($data);
				$this->send_output($data, 404);
				break;
			case 405:
				$data['error_type']       = 'Method Not Allowed';
				$data['message']          = 'Attempting to use the POST method when resource only accepts the GET method, or vice versa. Can also be applied to PUT and DELETE. Be sure to use an appropriate method for this resource.';
				ksort($data);
				$this->send_output($data, 405);
				break;
			case 500:
				$data['error_type']       = 'Internal Server Error';
				$data['message']          = 'An internal server error has occurred. Please try again soon.';
				ksort($data);
				$this->send_output($data, 500);
				break;
			default:
				if (isset($options['error_type'])) 
				{
					$data['error_type'] = $options['error_type'];
				}
				else
				{
					$data['error_type'] = 'Unkown';
				}
				if (isset($options['message'])) 
				{
					$data['message'] = $options['message'];
				}
				if (isset($options['http_status_code'])) 
				{
					$http_status_code = $options['http_status_code'];
				}
				else
				{
					$http_status_code = 500;
				}
				ksort($data);
				$this->send_output($data, $http_status_code);
				break;
		}
	}
	
	/**
	 * format and send output
	 *
	 * @param mixed $formatted_data 
	 * @param int $http_status_code 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function send_output($data, $http_status_code)
	{
		switch ($this->format) {
			case 'json':
			default:
				$data = json_encode($data);
				header(':', TRUE, $http_status_code);
				header('Content-type: application/json');
				echo $data;
				break;
		}
	}
}