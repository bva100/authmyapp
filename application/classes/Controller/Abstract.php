<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract Controller. All controller should extend this class.
 *
 * @author BRIAN ANDERSON
 */
abstract class Controller_Abstract extends Controller_Template {
	
	/**
	 * template name. Kohana needs this to be public.
	 *
	 * @var string
	 */
	public $template;
	
	/**
	 * front end version. Used for css and js cache.
	 *
	 * @var string
	 */
 	public static $front_end_version;
	
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
	 * Stylesheet base url
	 *
	 * @var string
	 */
	protected $stylesheet_base_url;
	
	/**
	 * Javascript base url
	 *
	 * @var string
	 */
	protected $javascript_base_url;
	
	/**
	 * View for rendered page
	 *
	 * @var View object
	 */
	protected $view;
	
	/**
	 * set view
	 *
	 * @param View object $view
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function set_view(View $view)
	{
		$this->view = $view;
	}
	
	/**
	 * Set view's header
	 *
	 * @param string $header_string dir to view
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function set_view_header($header_string)
	{
		if ( ! is_string($header_string) )
		{
			trigger_error('view header expects argument 1, header_string, to be string', E_USER_WARNING);
		}
		
		$this->view->header = new View($header_string);
		if ( isset($this->user) ) 
		{
			$this->view->header->user = $this->user;
		}
	}
	
	/**
	 * Set view's sidebar
	 *
	 * @param string $sidebar_string 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function set_view_sidebar($sidebar_string, $page = '')
	{
		if ( ! is_string($sidebar_string)) 
		{
			trigger_error('set_view_sidebar expects argument 1, sidebar_string, to be string', E_USER_WARNING);
		}
		if ( isset($page) AND ! is_string($page)) 
		{
			trigger_error('set_view_footer expects argument 2, page, to be string', E_USER_WARNING);
		}
		$this->view->sidebar = new View($sidebar_string);
		$this->set_view_page($page);
	}
	
	/**
	 * set view page
	 *
	 * @param string $page 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function set_view_page($page)
	{
		if ( ! is_string($page) )
		{
			trigger_error('set_view_page expects argument 1, page, to be string', E_USER_WARNING);
		}
		$this->view->sidebar->page = $page;
	}
	
	/**
	 * set view footer
	 *
	 * @param string $footer_string 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function set_view_footer($footer_string)
	{
		if ( ! is_string($footer_string)) 
		{
			trigger_error('set_view_footer expects argument 1, footer_string, to be string', E_USER_WARNING);
		}
		$this->view->footer = new View($footer_string);
	}
	
	/**
	 * set template's view
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_temp_view()
	{
		if ( isset($this->view) )
		{
			$this->template->content = $this->view;
			if (isset($this->user) AND isset($this->view->header)) 
			{
				$this->add_css('main/home/header');
				$this->add_js('main/home/header');
			}
		}
	}
	
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
			$dao_user = $auth->get_user();
			if ($dao_user) 
			{
				$user = Factory_Model::create($dao_user);
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
	 * set requires_login
	 *
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
	 * get requires_login
	 *
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
 	public function requires_login()
	{
		return( (bool) $this->requires_login);
	}
	
	/**
	 * set requires_admin
	 * 
	 * @param bool $requires_admin
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function set_requires_admin($requires_admin)
	{
		if ( ! is_bool($requires_admin) )
		{
			trigger_error('set_requires_admin expects argument 1 to be type bool', E_USER_WARNING);
		}
		$this->requires_admin = $requires_admin;
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
	 * Checks for a pre-existing session or an auto login cookie and redirects
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	protected function auto_login()
	{
		// if user already has a session, auto login
		$auth = Factory_Authenticate::create( $this->auth_object );
		$response = $auth->logged_in();
		if ($response) 
		{
			$this->redirect('home', 302);
		}
		
		// check for auto auth cookie
		$response = $auth->auto_login();
		if ($response) 
		{
			$this->redirect('home', 302);
		}
	}
	
	/**
	 * set stylesheet_base_url
	 *
	 * @param string $stylesheet_base_url
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_stylesheet_base_url($stylesheet_base_url)
	{
		if ( ! is_string($stylesheet_base_url) )
		{
			trigger_error('set_stylesheet_base_url expects argument 1 to be type string', E_USER_WARNING);
		}
		$this->stylesheet_base_url = $stylesheet_base_url;
	}
	
	/**
	 * get stylesheet_base_url
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function stylesheet_base_url()
	{
		if ( ! isset($this->stylesheet_base_url)) 
		{
			$this->stylesheet_base_url = URL::base(TRUE).'assets/css/';
		}
		return($this->stylesheet_base_url);
	}
	
	/**
	 * Add a stylesheet
	 *
	 * @param string $stylesheet 
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function add_css($stylesheet)
	{
		if ( ! is_string($stylesheet)) 
		{
			trigger_error('add_css expects argument 1, stylesheet, to be a string', E_USER_WARNING);
		}
		$this->template->stylesheets[] = $this->stylesheet_base_url().$stylesheet.'.css';
	}
	
	/**
	 * Set javascript base url
	 *
	 * @param string $javascript_base_url
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_javascript_base_url($javascript_base_url)
	{
		if ( ! is_string($javascript_base_url)) 
		{
			trigger_error('set_javascript_base_url expects argument 1, javascript_base_url to be string', E_USER_WARNING);
		}
		$this->javascript_base_url = $javascript_base_url;
	}
	
	/**
	 * get javascript_base_url
	 *
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function javascript_base_url()
	{
		if ( ! isset($this->javascript_base_url))
		{
			$this->javascript_base_url = URL::base(TRUE).'assets/js/';
		}
		return($this->javascript_base_url);
	}
	
	public function add_js($javascript)
	{
		if ( ! is_string($javascript))
		{
			trigger_error('add_js expects argument 1, javascript, to be string', E_USER_WARNING);
		}
		$this->template->scripts[] = $this->javascript_base_url().$javascript.'.js';
	}
	
	/**
	 * abstract's before method
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function before()
	{
		// set template
		$this->template = 'templates/default';
		
		// set front end version
		self::$front_end_version = '?v=1';
		
		// run controller before
		parent::before();
		
		$this->set_auth_object( Auth::instance() ); // default to kohana's auth system
		$this->set_user();
		
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
			$this->template->title            = 'Facebook Connect For Your App &#8212; AuthMyApp';
			$this->template->meta_description = 'Easily connect your app or website to Facebook and simplify your user signup process. Sign up today for a free account.';
			$this->template->meta_copywrite   = 'AuthMyApp, INC';
			$this->template->favicon          = '/assets/img/favicon/favicon.ico';
			$this->template->favicon_image    = '/assets/img/favicon/favicon.png';
			$this->template->apple_touch_icon = '/assets/img/favicon/apple-touch-icon.png';
			
			// fb meta
			$this->template->fb_site_name   = 'Auth My App';
			$this->template->fb_title       = $this->template->meta_description;
			$this->template->fb_type        = 'website';
			$this->template->fb_url         = URL::base(TRUE);
			$this->template->fb_admin       = '164712480350937';
			$this->template->fb_img         = 'http://oi35.tinypic.com/2je4tbk.jpg'; // use non-ssl service
			$this->template->fb_description = $this->template->meta_description;
			
			// styles
			$this->template->stylesheets   = array();
			$this->add_css('bootstrap/bootstrap.min');
			
			// scripts
			$this->template->scripts = array();
			$this->add_js('jquery');
			$this->add_js('bootstrap/bootstrap.min');
		}
	}
}
