<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model_App class
 *
 * @author BRIAN ANDERSON
 */
class Model_App extends Model_Abstract implements Interface_Model_App {
	
	const DELIVERY_GET = 1;
	const DELIVERY_GET_ENCRYPTED = 2;
	
	const STORAGE_PHP_SESSION = 1;
	const STORAGE_MYSQL       = 2;
	const STRORAGE_POSTGRESQL = 3;
	const STORAGE_SQLITE      = 4;
	const STORAGE_ORACLE      = 5;
	
	/**
	 * Creates a new App with name and organization. If app name and org_id combo already exists, returns false. Otherwise returns Model_App object.
	 *
	 * @param Dao_Abstract $dao 
	 * @param string $name 
	 * @param int $organization_id 
	 * @return bool | Model_App object
	 * @author BRIAN ANDERSON
	 */
	public static function create_with_name_and_organization_id(Dao_Abstract $dao, $name, $organization_id)
	{
		// check for pre-existing app
		$pre_existing = self::exists($dao, $name, $organization_id);
		if ($pre_existing) 
		{
			return( Factory_Model::create($dao) );
		}
		else
		{
			$dao->clear();
		}
		
		if (isset($name))
		{
			if ( ! is_string($name) )
			{
				trigger_error('create_with_name_and_organization_id expects argument 2, name, to be string', E_USER_WARNING);
			}
			else
			{
				$this->set_name($name);
			}
		}
		if (isset($organization_id))
		{
			if ( ! is_int($organization_id) )
			{
				trigger_error('create_with_name_and_organization_id expects argument 3, organization_id, to be int', E_USER_WARNING);	
			}
			else
			{
				$this->set_organization_id($organization_id);
			}
		}
		$dao->create_timestamp = time();
		$dao->create();
		return Factory_Model::create($dao);
	}
	
	/**
	 * Creates a new Model_App object. Returns bool true if app already exists and Model_App on success.
	 *
	 * @param Dao_Abstract $dao 
	 * @return bool | Model_App object
	 * @author BRIAN ANDERSON
	 */
	public static function create(Dao_Abstract $dao)
	{
		return self::create_with_name_and_organization_id($dao, NULL, NULL);
	}
	
	/**
	 * Does this app already exit?
	 *
	 * @param Dao_Abstract $dao 
	 * @param string $name 
	 * @param int $organization_id 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public static function exists(Dao_Abstract $dao, $name, $organization_id)
	{
		if ($dao->loaded()) 
		{
			$dao->clear();
		}
		if ( ! is_string($name)) 
		{
			trigger_error('exists expects argument 2 , name, to be a string', E_USER_WARNING);
		}
		if ( ! is_int($organization_id)) 
		{
			trigger_error('exists expects argument 3, organization_id, to be int', E_USER_WARNING);
		}
		
		$name = str_replace(' ', '_', $name);
		
		$results = $dao->where('organization_id', '=', $organization_id)->and_where('name', '=', $name)->find();
		if ($results->loaded()) 
		{
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
	}
	
	/**
	 * set organization_id
	 *
	 * @param int $organization_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_organization_id($organization_id, $lazy = FALSE)
	{
		if ( ! is_int($organization_id))
		{
			trigger_error('set_organization_id expects argument 1 to be type int', E_USER_WARNING);
		}
		if ( $organization_id < 0 )
		{
			throw new Exception("Please enter a valid organization id", 1);
		}
		$this->dao->organization_id = $organization_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get organization_id
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function organization_id()
	{
		return( (int) $this->dao->organization_id);
	}
	
	/**
	 * set name
	 *
	 * @param string $name
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_name($name, $lazy = FALSE)
	{
		if ( ! is_string($name) )
		{
			trigger_error('set_name expects argument 1 to be type string', E_USER_WARNING);
		}
		if ( strlen($name) < 1 OR strlen($name) > 127 )
		{
			throw new Exception("Please enter a valid app name", 1);
		}
		$this->dao->name = $name;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get name
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function name()
	{
		return(ucwords(str_replace('_', ' ', $this->dao->name)));
	}
	
	/**
	 * set secret
	 *
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_secret($lazy = FALSE)
	{
		$secret = md5(uniqid(mt_rand(), TRUE));
		$this->dao->secret = $secret;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get secret
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function secret()
	{
		return($this->dao->secret);
	}
	
	/**
	 * set domain
	 *
	 * @param string $domain
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_domain($domain, $lazy = FALSE)
	{
		$valid = Valid::url($domain);
		if ( ! $valid) 
		{
			// attempt to add 'http://' and re-validate
			$domain = 'http://'.$domain;
			$valid = Valid::url($domain);
			if ( ! $valid) 
			{
				throw new Exception('Please enter a valid domain url', 1);
			}
		}
		
		// add trailing slash as nessisary
		if (substr($domain, -1, 1) !== '/') 
		{
			$domain = $domain.'/';
		}
		
		// set
		$this->dao->domain = $domain;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get domain
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function domain()
	{
		return($this->dao->domain);
	}
	
	/**
	 * set sender_uri
	 *
	 * @param string $sender_uri
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_sender_uri($sender_uri, $lazy = FALSE)
	{
		if ( ! is_string($sender_uri) )
		{
			trigger_error('set_sender_uri expects argument 1 to be type string', E_USER_WARNING);
		}
		if ( strlen($sender_uri) < 1 OR strlen($sender_uri) > 127 )
		{
			throw new Exception("Please enter a valid sender uri", 1);
		}
		
		
		$this->dao->sender_uri = $sender_uri;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get sender_uri
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function sender_uri()
	{
		return($this->dao->sender_uri);
	}
	
	/**
	 * Get absolute path to sender url
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function sender_url()
	{
		$uri = ltrim($this->sender_uri(), '/');
		return $this->domain().$uri;
	}
	
	/**
	 * set receiver_uri
	 *
	 * @param string $receiver_uri
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_receiver_uri($receiver_uri, $lazy = FALSE)
	{
		if ( ! is_string($receiver_uri) )
		{
			trigger_error('set_receiver_uri expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->receiver_uri = $receiver_uri;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get receiver_uri
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function receiver_uri()
	{
		return($this->dao->receiver_uri);
	}
	
	
	/**
	 * get absolute url to to receiver
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function receiver_url()
	{
		$uri = ltrim($this->receiver_uri(), '/');
		return $this->domain().$uri;
	}
	
	/**
	 * set post_auth_uri
	 *
	 * @param string $post_auth_uri
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_post_auth_uri($post_auth_uri, $lazy = FALSE)
	{
		if ( ! is_string($post_auth_uri) )
		{
			trigger_error('set_post_auth_uri expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->post_auth_uri = $post_auth_uri;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get post_auth_uri
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function post_auth_uri()
	{
		return($this->dao->post_auth_uri);
	}
	
	/**
	 * Get absolute url to post auth
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function post_auth_url()
	{
		$uri = ltrim($this->post_auth_uri(), '/');
		return $this->domain().$uri;
	}
	
	/**
	 * set delivery_method
	 *
	 * @param int $delivery_method. Consts defined at top of class.
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_delivery_method($delivery_method, $lazy = FALSE)
	{
		if ( ! is_int($delivery_method) )
		{
			trigger_error('set_delivery_method expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->delivery_method = $delivery_method;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get delivery_method
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function delivery_method()
	{
		return($this->dao->delivery_method);
	}
	
	/**
	 * set storage_method
	 *
	 * @param int $storage_method. Ints defined by consts in this class.
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_storage_method($storage_method, $lazy = FALSE)
	{
		if ( ! is_int($storage_method) )
		{
			trigger_error('set_storage_method expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->storage_method = $storage_method;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get storage_method
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function storage_method()
	{
		return( (int) $this->dao->storage_method);
	}
	
	/**
	 * Create and set a new salt
	 *
	 * @param string $salt
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_salt($lazy = FALSE)
	{
		$salt = md5(uniqid(mt_rand(), TRUE));
		$this->dao->salt = $salt;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get salt
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function salt()
	{
		return($this->dao->salt);
	}
	
	/**
	 * set picture_width
	 *
	 * @param int $picture_width
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_picture_width($picture_width, $lazy = FALSE)
	{
		if ( ! is_int($picture_width) )
		{
			trigger_error('set_picture_width expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->picture_width = $picture_width;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get picture_width
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function picture_width()
	{
		return( (int) $this->dao->picture_width);
	}
	
	/**
	 * set picture_height
	 *
	 * @param int $picture_height
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_picture_height($picture_height, $lazy = FALSE)
	{
		if ( ! is_int($picture_height) )
		{
			trigger_error('set_picture_height expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->picture_height = $picture_height;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get picture_height
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function picture_height()
	{
		return( (int) $this->dao->picture_height);
	}
	
	/**
	 * get message
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function message()
	{
		return($this->dao->message);
	}
	
	
	/**
	 * set facebook_app_id
	 *
	 * @param int| float $facebook_app_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_app_id($facebook_app_id, $lazy = FALSE)
	{
		$this->dao->facebook_app_id = $facebook_app_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get facebook_app_id
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function facebook_app_id()
	{
		return($this->dao->facebook_app_id);
	}
	
	/**
	 * set facebook_secret
	 *
	 * @param string $facebook_secret
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_facebook_secret($facebook_secret, $lazy = FALSE)
	{
		if ( ! is_string($facebook_secret) )
		{
			trigger_error('set_facebook_secret expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->facebook_secret = $facebook_secret;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get facebook_secret
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function facebook_secret()
	{
		return($this->dao->facebook_secret);
	}
	
	/**
	 * returns an array used to initialize facebook sdk object
	 *
	 * @return array. "appId" and "secret"
	 * @author BRIAN ANDERSON
	 */
	public function facebook_config()
	{
 		return array(
			'appId' => $this->facebook_app_id(),
			'secret' => $this->facebook_secret(),
		);
	}
	
}
