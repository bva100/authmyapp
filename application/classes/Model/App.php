<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model_App class
 *
 * @author BRIAN ANDERSON
 */
class Model_App extends Model_Abstract implements Interface_Model_App {
	
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
			return(TRUE);
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
				$dao->name = str_replace(' ', '_', $name);
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
				$dao->organization_id = $organization_id;
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
	 * set organization_id
	 *
	 * @param int $organization_id
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_organization_id($organization_id, $lazy = FALSE)
	{
		if ( ! is_int($organization_id) )
		{
			trigger_error('set_organization_id expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->organization_id = $organization_id;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get organizaton_id
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
	 * set redirect_url
	 *
	 * @param string $redirect_url
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_redirect_url($redirect_url, $lazy = FALSE)
	{
		if ( ! is_string($redirect_url) )
		{
			trigger_error('set_redirect_url expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->dao->redirect_url = $redirect_url;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get redirect_url
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function redirect_url()
	{
		return($this->dao->redirect_url);
	}
	
	/**
	 * set delivery_method
	 *
	 * @param string $delivery_method
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_delivery_method($delivery_method, $lazy = FALSE)
	{
		if ( $delivery_method !== 'post' OR $delivery_method !== 'get') 
		{
			trigger_error('delivery method must be either "post" or "get"', E_USER_WARNING);
		}
		$this->dao->delivery_method = $delivery_method;
		if ( ! $lazy)
		{
			$this->db_update();
		}
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
