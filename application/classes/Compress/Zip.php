<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Compress files using php native zip.
 *
 * @author BRIAN ANDERSON
 */
class Compress_Zip extends Compress_Abstract {
	
	/**
	 * Compress using zip
	 *
	 * @param string $value 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function execute()
	{
		$valid_files = array();
		
		// check for existing file
		if( file_exists($this->destination) AND ! $this->overwrite)
		{ 
			return(FALSE);
		}
		
		// add to valid_files array only if file exists
		foreach($this->files as $file)
		{
			if( file_exists($file) )
			{
				$valid_files[] = $file;
			}
		}
		
		// create archive if files were found
		if( count($valid_files) )
		{
			// create new zip archive object
			$zip = new ZipArchive();
			if( $zip->open( $this->destination, $this->overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== TRUE) 
			{
				return(FALSE);
			}
			
			//add files
			foreach($valid_files as $file) 
			{
				if (isset($this->archive_dir)) 
				{
					$filename = $this->filename($file);
					$path = $this->archive_dir.$filename;
				}
				else
				{
					$path = $file;
				}
				$zip->addFile($file, $path);
			}
			
			//debug
			// echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
			
			//close zip
			$zip->close();

			//check to make sure the file exists
			return file_exists($this->destination);
		}
		else
		{
			return false;
		}
	}
}
