<?php defined('SYSPATH') or die('No direct script access.');
if (Kohana::$environment === 'prod') 
{
	/**
	 * 500
	 *
	 * @package default
	 * @author BRIAN ANDERSON
	 */
	class HTTP_Exception_500 extends Kohana_HTTP_Exception_500 {

		public function get_response()
		{
			$response = Response::factory();
			$view = View::factory('errors/500');
			$view->message = $this->getMessage();
			$response->body($view->render());
			return $response;
		}

	}
}