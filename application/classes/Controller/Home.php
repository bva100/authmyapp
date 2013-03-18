<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Base controller for core app functionality
 *
 * @author BRIAN ANDERSON
 */
class Controller_Home extends Controller_Abstract {
	
	public function before()
	{
		$this->set_requires_login(TRUE);
		$this->set_requires_admin(FALSE);
		parent::before();
		$this->add_css('main/home/index');
		$this->add_js('main/home/index');
		$this->add_css('main/home/header');
		$this->add_js('main/home/header');
		$this->add_css('main/home/sidebar');
	}
	
	public function action_logout()
	{
		$this->auth_object->logout();
		$this->redirect('welcome', 302);
	}
	
	public function action_index()
	{
		$view                = new View('main/home/index');
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'manage';
		$this->template->set('content', $view);
	}
	
	public function action_addApp()
	{
		$name    = (string) get('name', '');
		$domain  = (string) get('domain', '');
		$new_org = (string) get('new_org', '');
		$uri     = (string) get('uri', '');
		
		$view = new View('main/home/addapp');
		$view->user = $this->user();
		$view->header = new view('main/home/header');
		$view->header->user = $this->user();
		$this->template->set('content', $view);
		$this->add_js('main/home/addapp');
	}
	
	public function action_addAppProcess()
	{
		$name         = (string) post('name', '');
		$domain       = (string) post('domain', '');
		$organization = (int)    post('organization', 0);
		$new_org      = (string) post('newOrganization', '');
		$uri          = (string) post('uri', '');
		
		if ( ! $name) 
		{
			throw new Exception('Please enter a valid name');
		}
		if ( ! $domain) 
		{
			throw new Exception('Please enter a valid domain');
		}
		else if ( ! Valid::url($domain))
		{
			throw new Exception('Please enter a valid domain', 1);
		}
		if ( ! $uri)
		{
			$uri = Model_App::DEFAULT_REDIRECT_URI;
		}
		else if (substr($uri, 0, 1) !== '/')
		{
			$uri = '/'.$uri;
		}
		$uri = str_replace(' ', '', $uri);
		
		if ( ! $organization) 
		{
			// create organization with new_org as name
			$dao_org = Factory_Dao::create('kohana', 'organization');
			$org     = Model_Organization::create_with_name($dao_org, $new_org);
			$org->set_url($domain, TRUE);
			$org->set_state(Model_Organization::STATE_ACTIVE);
			
			// add user to organization
			$this->user->add_organization($org->id());
		}
		else
		{
			// create org object
			$dao_org = Factory_Dao::create('kohana', 'organization', $organization);
			$org     = Factory_Model::create($dao_org);
		}
		
		// create app
		$dao_app = Factory_Dao::create('kohana', 'app');
		$app     = Model_App::create_with_name_and_organization_id($dao_app, $name, $org->id());
		$app->set_secret(TRUE);
		$app->set_redirect_url($domain.$uri, TRUE);
		$app->set_delivery_method('get', TRUE);
		$app->set_state(Model_App::STATE_ACTIVE);
		
		// complete
		$message = $name.' has been successfully added to your AuthMyApp account';
		$this->redirect('home/downloads?app_id='.$app->id().'&message='.$message.'&message_type=success', 302);
	}
	
	public function action_downloads()
	{
		$app_id       = (int) get('app_id', 0);
		$message      = (string) get('message', '');
		$message_type = (string) get('message_type', '');
		if ($app_id) 
		{
			$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao_app);
		}
		else
		{
			$app = FALSE;
		}
		
		$view = new View('main/home/downloads');
		$view->message = $message;
		$view->message_type = $message_type;
		$view->app = $app;
		$view->user = $this->user();
		$view->header = new View('main/home/header');
		$view->header->user = $this->user();
		$view->sidebar = new View('main/home/sidebar');
		$view->sidebar->page = 'downloads';
		$this->template->set('content', $view);
		$this->add_js('main/home/downloads');
	}
}
