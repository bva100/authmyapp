<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Script abstract class. All script classes must extend this.
 *
 * @author BRIAN ANDERSON
 */
abstract class Script_Abstract {
	
	/**
	 * Model_User object
	 *
	 * @var Model_User
	 */
	protected $user;
	
	/**
	 * Model_App object
	 *
	 * @var Model_App
	 */
	protected $app;
	
	/**
	 * Hash_Abstract object
	 *
	 * @var Hash_Abstract
	 */
	protected $hash_algo;
	
	/**
	 * Name of compression type. Optional. Set to null to turn compression off. Should NOT have leading period/dot
	 *
	 * @var string
	 */
	protected $compression_type;
	
	/**
	 * Path to source of file (just dir not filename)
	 *
	 * @var string
	 */
	protected $path;
	
	/**
	 * Path using url
	 *
	 * @var string
	 */
	protected $url_path;
	
	/**
	 * dir structure to save archive. Should NOT have a leading path
	 *
	 * @var string
	 */
	protected $archive_path;
	
	/**
	 * File name without extension nor directorie
	 *
	 * @var string
	 */
	protected $filename;
	
	/**
	 * Original filetype extension. Should NOT have leading period/dot
	 *
	 * @var string
	 */
	protected $orig_extension;
	
	/**
	 * Constructor. Inject Model_User, Model_App. Also set a string for the archive path (directory)
	 *
	 * @param Model_User $user
	 * @param Model_App $app
	 * @param string $archive_path
	 * @author BRIAN ANDERSON
	 */
	public function __construct(Model_User $user, Model_App $app, array $data)
	{
		// set vars
		$this->set_user($user);
		$this->set_app($app);
		$this->set_data($data);
		
		// check access
		$this->check_access();
		
		// set defaults
		$this->set_hash_algo( Factory_Hash::create( Auth::instance() ) );
		$this->set_path( $_SERVER['DOCUMENT_ROOT'].'/assets/downloads/' );
		$this->set_url_path( URL::base(TRUE).'assets/downloads/' );
		
		// set file data
		$this->set_file_data();
	}
	
	/**
	 * set user
	 *
	 * @param Model_User $user
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_user(Model_User $user)
	{
		$this->user = $user;
	}
	
	/**
	 * get user
	 *
	 * @return Model_User object
	 * @author BRIAN ANDERSON
	 */
	public function user()
	{
		return($this->user);
	}
	
	/**
	 * set app
	 *
	 * @param Model_App $app
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_app(Model_App $app)
	{
		$this->app = $app;
	}
	
	/**
	 * get app
	 *
	 * @return Model_App object
	 * @author BRIAN ANDERSON
	 */
	public function app()
	{
		return($this->app);
	}
	
	/**
	 * set hash_algo
	 *
	 * @param Hash_Abstract $hash_algo
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_hash_algo(Hash_Base $hash_algo)
	{
		$this->hash_algo = $hash_algo;
	}
	
	/**
	 * get hash_algo
	 *
	 * @return Hash_Abstract
	 * @author BRIAN ANDERSON
	 */
	public function hash_algo()
	{
		return($this->hash_algo);
	}
	
	/**
	 * set compression_type
	 *
	 * @param string $compression_type
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_compression_type($compression_type)
	{
		if ( ! is_string($compression_type) )
		{
			trigger_error('set_compression_type expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->compression_type = $compression_type;
	}
	
	/**
	 * get compression_type
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function compression_type()
	{
		return($this->compression_type);
	}
	
	/**
	 * set path
	 *
	 * @param string $path
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_path($path)
	{
		if ( ! is_string($path) )
		{
			trigger_error('set_path expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->path = $path;
	}
	
	/**
	 * get path
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function path()
	{
		return($this->path);
	}
	
	/**
	 * set url_path
	 *
	 * @param string $url_path
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_url_path($url_path)
	{
		if ( ! is_string($url_path) )
		{
			trigger_error('set_url_path expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->url_path = $url_path;
	}
	
	/**
	 * get url_path
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function url_path()
	{
		return($this->url_path);
	}
	
	/**
	 * set archive_path
	 *
	 * @param string $archive_path
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_archive_path($archive_path)
	{
		if ( ! is_string($archive_path) )
		{
			trigger_error('set_archive_path expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->archive_path = $archive_path;
	}
	
	/**
	 * get archive_path
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function archive_path()
	{
		return($this->archive_path);
	}
	
	/**
	 * set orig_extension
	 *
	 * @param string $orig_extension
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_orig_extension($orig_extension)
	{
		if ( ! is_string($orig_extension) )
		{
			trigger_error('set_orig_extension expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->orig_extension = $orig_extension;
	}
	
	/**
	 * get orig_extension
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function orig_extension()
	{
		return($this->orig_extension);
	}
	
	/**
	 * set filename
	 *
	 * @param string $filename
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_filename($filename)
	{
		if ( ! is_string($filename) )
		{
			trigger_error('set_filename expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->filename = $filename;
	}
	
	/**
	 * get filename
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function filename()
	{
		return($this->filename);
	}
	
	/**
	 * set data
	 *
	 * @param array $data
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_data(array $data)
	{
		$this->data = $data;
	}
	
	/**
	 * get data
	 *
	 * @return array
	 * @author BRIAN ANDERSON
	 */
	public function data()
	{
		return($this->data);
	}
	
	/**
	 * Does user have download access?
	 *
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public function check_access()
	{
		if ($this->user->plan()->downloads())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Create data for file (file_data) by using previously set data array
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	abstract public function set_file_data();
	
	/**
	 * Create file. Each class extending implements this in their own way.
	 *
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	abstract public function create();
	
	/**
	 * Create a string optimized for copy and paste
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	abstract public function create_text();
	
	/**
	 * get url associated with created file
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	abstract public function url();
	
}
