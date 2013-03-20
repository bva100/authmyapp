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
		$message    = (string) get('message', '');
		$alert_type = (string) get('alert_type', 'warning');
		
		$view                      = new View('main/home/index');
		$view->user                = $this->user();
		if ($message AND $alert_type) 
		{
			$view->alert               = new View('alert');
			$view->alert->message      = $message;
			$view->alert->type         = $alert_type;
		}
		$view->header              = new View('main/home/header');
		$view->header->user        = $this->user();
		$view->sidebar             = new View('main/home/sidebar');
		$view->sidebar->page       = 'manage';
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
		
		// redirect
		if ($this->user->plan()->name() === 'free') 
		{
			// if using free plan redirect to account upgrade page with app_id
			$this->redirect('home/plans?app_id='.$app->id.'&new_app='.TRUE, 302);
		}
		else
		{
			// if using premium plan redirect to downloads page with app_id
			$message = urlencode($app->name().' has been successfully added to your account');
			$this->redirect('home/downloads?message='.$message.'&alert_type="success"', 302);
		}
	}
	
	public function action_plans()
	{
		$app_id  = (int)  get('app_id', 0);
		$new_app = (bool) get('new_app', FALSE);
		$limit   = get('limit', 4);
		
		// plan name
		$plan_name = $this->user->plan()->name();
		
		// null limit
		if ($limit === 'null' OR ( $plan_name === 'Platinum' OR $plan_name === 'Platinum Plus' ) )
		{
			$limit = NULL;
		}
		
		// create app object
		if ($app_id) 
		{
			$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao_app);
		}
		else
		{
			$app = FALSE;
		}
		
		//create plans object
		$dao_plan = Factory_Dao::create('kohana', 'plan');
		$plans = Model_Plan::all($dao_plan, Model_Plan::STATE_ACTIVE, 'ASC', $limit);
		
		$view                = new View('main/home/plans');
		$view->app           = $app;
		$view->new_app       = $new_app;
		$view->limit         = $limit;
		$view->plans         = $plans;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'plan';
		$this->template->set('content', $view);
	}
	
	public function action_plansProcess()
	{
		$plan_id = (int) post('plan_id', 1);
		$app_id  = (int) post('app_id', 0);
		$new_app = (bool) post('new_app', FALSE);
		
		$this->user->set_plan_id($plan_id);
		
		// wepay integration here...
		
		$dao_plan = Factory_Dao::create('kohana', 'plan')->where('name', '=', 'free')->find();
		$plan = Factory_Model::create($dao_plan);
		
		// redirect
		if ($app_id AND $new_app )
		{
			$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao_app);
			
			if ($plan_id !== $plan->id()) 
			{
				$dao = Factory_Dao::create('kohana', 'app', $app_id);
				$app = Factory_Model::create($dao);
				$this->redirect('home/downloads?app_id='.$app->id().'&new_app='.TRUE, 302);
			}
			else
			{
				$message = urlencode( $app->name().' is ready to go. Be sure to click on the help link in the navigation bar for integration tutorials');
				$this->redirect('home?message='.$message.'&alert_type=success', 302);
			}
		}
		else
		{
			$this->redirect('home/plans', 302);
		}
		
	}
	
	public function action_downloads()
	{
		$app_id  = (int)  get('app_id', 0);
		$new_app = (bool) get('new_app', FALSE);
		
		if ($app_id) 
		{
			$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao_app);
		}
		else
		{
			$app = FALSE;
		}
		
		$view                = new View('main/home/downloads');
		$view->app           = $app;
		$view->new_app       = $new_app;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'downloads';
		$this->template->set('content', $view);
		$this->add_js('main/home/downloads');
	}
	
	public function action_downloadsProcess()
	{
		$type   = (string) post('type', '');
		$app_id = (int)    post('app_id', 0);
		$text   = (string) post('text', '');
		$size = (string) post('size', 'small');
		
		$data = array(
			'text' => $text,
			'size' => $size,
		);
		
		// objects
		$hash_algo = Factory_Hash::create( Auth::instance() );
		$app_dao   = Factory_Dao::create('kohana', 'app', $app_id);
		$app       = Factory_Model::create($app_dao);
		$script    = Factory_Script::create($type, $this->user, $app, $data);
		$script->set_compression_type('zip');
		
		// create file
		$results = $script->create();
		if ( ! $results) 
		{
			throw new Exception('We cannot complete your request at this time, please try again soon', 1);
		}
		
		// redirect or print url on ajax
		if ( ! $this->request->is_ajax())
		{
			$this->redirect($script->url(), 302);
		}
		else
		{
			$this->auto_render = FALSE;
			$this->response->body($script->url());
		}
		
		// delete with cron here
		
		
	}
	
}
