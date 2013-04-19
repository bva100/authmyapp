<?php defined('SYSPATH') or die('No direct script access.');
if (Kohana::$environment === 'prod') 
{
	/**
	 * 404
	 *
	 * @package default
	 * @author BRIAN ANDERSON
	 */
	class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {

		public function get_response()
		{
			$response = Response::factory();
			$view = View::factory('errors/404');
			$view->message = $this->getMessage();
			$response->body($view->render());
			return $response;
		}

	}
}