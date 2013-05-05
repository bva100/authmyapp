<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Test class. Delete this class.
 *
 * @author BRIAN ANDERSON
 */
class Controller_Pimple extends Controller {
	
	/**
	 * Pimple service container
	 *
	 * @var Service_Container Object
	 */
	protected $service_container;
	
	/**
	 * set service container
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_service_container()
	{
		$this->service_container = new Service_Container();
	}
	
	public function action_index()
	{
		$container = new Pimple();
		$container['user.ormService'] = function () {
			return Factory_Dao::create('kohana', 'user', 1);
		};
		echo Debug::vars($container['user.ormService']); die;
	}
	
}
