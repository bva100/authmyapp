<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Factory for compress strategy pattern
 *
 * @author BRIAN ANDERSON
 */
class Factory_Compress extends Factory_Abstract {
	
	/**
	 * Create a new compress object by passing compression method, (array) files, (string) destination, (string) archive_dir, and (bool) overwrite
	 *
	 * @param string $type 
	 * @param array $files 
	 * @param string $destination 
	 * @param string $archive_dir. Set dir for files within archive. Leave null to use source dir.
	 * @param string $archive_name. Set target name for file. Only works if a single file is uploaded.
	 * @param bool $overwrite 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function create($type, array $files, $destination, $archive_dir, $archive_name, $overwrite = TRUE)
	{
		if ( ! is_string($destination)) 
		{
			trigger_error('Factory_Compress::create expects argument 3, destination, to be string', E_USER_WARNING);
		}
		if ( ! is_bool($overwrite)) 
		{
			trigger_error('Factory_Compress::create expects argument 4, overwrite, to be bool', E_USER_WARNING);
		}
		switch ($type) {
			case 'zip':
				return new Compress_Zip($files, $destination, $archive_dir, $archive_name, $overwrite);
				break;
			default:
				trigger_error('Factory_Compress::create does not recognize type '.$type, E_USER_WARNING);
				break;
		}
	}
	
}
