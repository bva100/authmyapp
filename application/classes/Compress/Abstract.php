<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract Compress class. All compress implementations should extend this class
 *
 * @author BRIAN ANDERSON
 */
abstract class Compress_Abstract {
	
	/**
	 * an array of files with full path dir and extenstions
	 *
	 * @var array
	 */
	protected $files;
	
	/**
	 * destination of zip archive, full path
	 *
	 * @var string
	 */
	protected $destination;
	
	/**
	 * Put files into which directory inside of the archive?
	 *
	 * @var string
	 */
	protected $archive_dir;
	
	/**
	 * Save file as what name inside archive dir?
	 *
	 * @var string
	 */
	protected $archive_name;
	
	/**
	 * Overwrite previously existing files?
	 *
	 * @var bool
	 */
	protected $overwrite;
	
	/**
	 * Constructor sets files, destination and overwrite vars
	 *
	 * @param array $files 
	 * @param string $destination 
	 * @param string $archive_dir . Set dir for files within archive. Leave null to use source dir.
	 * @param string $archive_name. Save file as what name inside archive dir? Only works if a single file is uploaded.
	 * @param bool $overwrite 
	 * @author BRIAN ANDERSON
	 */
	public function __construct(array $files, $destination, $archive_dir = NULL, $archive_name = NULL, $overwrite = TRUE)
	{
		if ( ! is_string($destination)) 
		{
			trigger_error('Compress_Abstract::construct() expects argument 2, destination, to be string (fullpath)', E_USER_WARNING);
		}
		if (isset($archive_dir) AND ! is_string($archive_dir)) 
		{
			trigger_error('Compress_Abstract::construct() expects argument 3, archive_dir, to be string', E_USER_WARNING);
		}
		if (isset($target_name) AND ! is_string($target_name)) 
		{
			trigger_error('Compress_Abstract::construct() expects argument 4, archive_name, to be string', E_USER_WARNING);
		}
		if ( ! is_bool($overwrite)) 
		{
			trigger_error('Compress_Abstract::construct() expects argument 5, overwrite, to be bool', E_USER_WARNING);
		}
		
		$this->files        = $files;
		$this->destination  = $destination;
		$this->archive_dir  = $archive_dir;
		$this->archive_name = $archive_name;
		$this->overwrite    = $overwrite;
	}
	
	/**
	 * gets a filename given its full path with dir
	 *
	 * @return array Dictionary setup as: keys is filepath and value is filename
	 * @author BRIAN ANDERSON
	 */
	protected function filename($filename)
	{
		// if directory path exists, strip it from filename
		$non_dir_filename = strrchr($filename, '/');
		if ($non_dir_filename) 
		{
			// strip last '/'
			$filename = substr( $non_dir_filename, 1);
		}
		return $filename;
	}
	
	/**
	 * Leave compressing implementation up to extended class
	 *
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	abstract public function execute();
}
