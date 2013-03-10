<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Creates a Hash decorator object
 *
 * @author BRIAN ANDERSON
 */
class Factory_Hash extends Factory_Abstract {
	
	public static function create(Hash_Abstract $hash_algo)
	{
 		return new Hash_Base($hash_algo);
	}
	
}
