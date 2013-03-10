<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract factory class. All factory classes must extend this.
 *
 * @author BRIAN ANDERSON
 */
abstract class Factory_Abstract {
	
	/**
	 * all methods should be static
	 * @author BRIAN ANDERSON
	 */
	private function __construct()
	{
	}
	
	/**
	 * prevent cloning
	 * @author BRIAN ANDERSON
	 */
	private function __clone()
	{
	}
}