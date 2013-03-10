<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract class for all Hash Algos. All Hash Algos must extend this class.
 *
 * @author BRIAN ANDERSON
 */
abstract class Hash_Abstract {
	
	/**
	 * hash name of algo
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	abstract public function hash_name();
	
	/**
	 * hash a string
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	abstract public function hash($str);
	
}
