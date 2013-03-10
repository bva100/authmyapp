<?php defined('SYSPATH') or die('No direct script access.');

/**
 * hash algo decorator.
 *
 * @author BRIAN ANDERSON
 */
class Hash_Base {
	
	/**
	 * Stores a valid Hash_Algo object
	 *
	 * @var Hash_Abstract object
	 */
	private $hash_algo;
	
	/**
	 * Constructor sets hash_algo object
	 *
	 * @author BRIAN ANDERSON
	 */
	public function __construct(Hash_Abstract $hash_algo)
	{
		$this->set_hash_algo($hash_algo);
	}
	
	/**
	 * set hash_algo
	 *
	 * @param object $hash_algo
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_hash_algo(Hash_Abstract $hash_algo)
	{
		$this->hash_algo = $hash_algo;
	}
	
	/**
	 * get hash_algo
	 *
	 * @return Abstract_Base object
	 * @author BRIAN ANDERSON
	 */
	public function hash_algo()
	{
		return($this->hash_algo);
	}
	
	/**
	 * get name
	 *
	 * @return string. name/type of hash algo.
	 * @author BRIAN ANDERSON
	 */
	public function name()
	{
		return($this->hash_algo->hash_name());
	}
	
	public function hash($str)
	{
		return $this->hash_algo->hash($str);
	}
	
}
