<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract Controller. All controller should extend this class.
 *
 * @author BRIAN ANDERSON
 */
abstract class Controller_Abstract extends Controller_Template{
	
	/**
	 * template name. Kohana needs this to be public.
	 *
	 * @var string
	 */
	public   $template = "templates/default";
	
	/**
	 * front end version. Used for css and js cache.
	 *
	 * @var string
	 */
 	public static $front_end_version  = "?v=1";
	
	/**
	 * holds an instance of an auth object which is injected into the Authenticate class
	 *
	 * @var object
	 */
	protected $auth_object;
	
	/**
	 * holds an instance of Model_User user
	 *
	 * @var Model_User object
	 */
	protected $user;
	
	/**
	 * Determines if login is required
	 *
	 * @var bool
	 */
	protected $requires_login;
	
	/**
	 * Determines if admin level access is requires
	 *
	 * @var bool
	 */
	protected $requires_admin;
	
	/**
	 * set auth_object
	 *
	 * @param object $auth_object
	 * @return void
	 * @author BRIAN ANDERSON
	 */
 	protected function set_auth_object($auth_object)
	{
		if ( ! is_object($auth_object) )
		{
			trigger_error('set_auth_object expects argument 1 to be type object', E_USER_WARNING);
		}
		$this->auth_object = $auth_object;
	}
	
	/**
	 * get auth_object
	 * @return object
	 * @author BRIAN ANDERSON
	 */
 	protected function auth_object()
	{
		return($this->auth_object);
	}
	
	/**
	 * set's the controllers user. If $user is not passed, pulls $db_user from session and creates/sets a new Model_User instance
	 *
	 * @param Model_User $user 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
 	protected function set_user(Model_User $user = NULL)
	{
		if ( ! $user)
		{
			$auth = Factory_Authenticate::create( $this->auth_object );
			$db_user = $auth->get_user();
			if ($db_user) 
			{
				$user = Factory_Model_User::create($db_user);
			}
			else
			{
				$user = NULL;
			}
		}
		$this->user = $user;
	}
	
	/**
	 * get user
	 *
	 * @return Model_User object
	 * @author BRIAN ANDERSON
	 */
 	protected function user()
	{
		return($this->user);
	}
	
	/**
	 * set requires_login.
	 * @param bool $requires_login
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function set_requires_login($requires_login)
	{
		if ( ! is_bool($requires_login) )
		{
			trigger_error('set_requires_login expects argument 1 to be type bool', E_USER_WARNING);
		}
		$this->requires_login = $requires_login;
	}
	
	/**
	 * get requires_admin
	 * 
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
 	public function requires_admin()
	{
		return( (bool) $this->requires_admin);
	}
	
	/**
	 * Checks for required login, a set user and access levels. If requirements are not met, redirect to welcome controller. Add stored_uri here later. Call this after calling set_user.
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function check_access()
	{
		// check login
		if ( $this->requires_login() AND ! $this->user ) 
		{
			$this->redirect("welcome/login", 302);
		}
		
		// if necessary, check access level
		if ( $this->requires_admin ) 
		{
			$auth = Factory_Authenticate::create( $this->auth_object );
			$approved = $auth->logged_in('admin');
			if ( ! $approved ) 
			{
				throw new Exception('Access Denied. You must have admin level access to visit this page', 1);
			}
		}
	}
	
	/**
	 * abstract's before method
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function before()
	{
		parent::before();
		
		$this->set_auth_object( Auth::instance() ); // default to kohana's auth system
		$this->set_user();
		$this->set_uri();
		
		// by default, user's should be logged in and admin access is not required.
		if ( ! isset($this->requires_login)) 
		{
			$this->set_requires_login(TRUE);
		}
		if ( ! isset($this->requires_admin)) 
		{
			$this->set_requires_admin(FALSE);
		}
		$this->check_access();
		
		if($this->auto_render)
		{
			//meta
			$this->template->title            = '';
			$this->template->meta_description = '';
			$this->template->meta_copywrite   = 'AuthMyApp, INC';
			$this->template->favicon          = URL::base(TRUE).'favicon.ico';
			$this->template->favicon_image    = URL::base(TRUE).'favicon.png';
			$this->template->apple_touch_icon = URL::base(TRUE).'apple-touch-icon.png';
			
			// fb meta
			$this->template->fb_site_Name   = 'AuthMyApp';
			$this->template->fb_title       = $this->template->meta_description;
			$this->template->fb_type        = 'website';
			$this->template->fb_url         = URL::base(TRUE);
			$this->template->fb_admin       = '';
			$this->template->fb_img         = ''; // use a non ssl service
			$this->template->fb_description = $this->template->meta_description;
			
			// scripts and styles
			$this->template->jquery                 = 'https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'; // perhaps dl this
			$this->template->googleAnalytics        = 'assets/js/googleAnalytics.js';
			$this->template->content                = '';
			$this->template->bootstrapCss           = 'assets/bootstrap/css/bootstrap.min.css';
			$this->template->bootstrapJs            = 'assets/bootstrap/js/bootstrap.min.js';
			$this->template->templateJs             = 'assets/js/templates/templateJs.js'.self::$front_end_version;
			$this->template->templateCss            = 'assets/css/templates/template.css'.self::$front_end_version;
			
			
			$this->template->navbar  = '';
			$this->template->styles  = '';
			$this->template->scripts = '';
		}
	}
	
}
