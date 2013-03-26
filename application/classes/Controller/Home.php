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
		$organization = (int)    post('organization', 0);
		$new_org      = (string) post('newOrganization', '');
		$domain       = (string) post('domain', '');
		$postAuthUrl  = (string) post('postAuthUrl', '');
		$senderUri    = (string) post('senderUir', '');
		$receiverUri  = (string) post('receiverUri', '');
		
		if ( ! $organization) 
		{
			// create organization with new_org as name
			$dao_org = Factory_Dao::create('kohana', 'organization');
			$org     = Model_Organization::create_with_name($dao_org, $new_org);
			$org->set_url($domain, TRUE);
			$org->set_state(Model_Organization::STATE_ACTIVE);
			
			// add user to organization
			$this->user->add_organization($org->id());
		}else{
			// create org object
			$dao_org = Factory_Dao::create('kohana', 'organization', $organization);
			$org     = Factory_Model::create($dao_org);
		}
		if ( ! $postAuthUrl) 
		{
			$postAuthUri = '/welcome';
		}
		else
		{
			$postAuthUri = str_replace($domain, '', $postAuthUrl);
		}
		if ( ! $senderUri ) 
		{
			$senderUri = '/AuthMyAppDirectionSender';
		}
		if ( ! $receiverUri ) 
		{
			$receiverUri = '/AuthMyAppReceiver';
		}
		
		// create app
		$dao_app = Factory_Dao::create('kohana', 'app');
		$app     = Model_App::create_with_name_and_organization_id($dao_app, $name, $org->id());
		$app->set_secret(TRUE);
		$app->set_domain($domain, TRUE);
		$app->set_post_auth_uri($postAuthUri, TRUE);
		$app->set_sender_uri($senderUri, TRUE);
		$app->set_receiver_uri($receiverUri, TRUE);
		$app->set_delivery_method(Model_App::DELIVERY_GET, TRUE); // hardcoded until options are available. Can change in app settings or on receiver download.
		$app->set_storage_method(Model_App::STORAGE_PHP_SESSION, TRUE); // user can change this when downloading receiver or in app options
		$app->set_salt(TRUE);
		$app->set_state(Model_App::STATE_ACTIVE);
		
		// redirect
		if ($this->user->plan()->name() === 'free' OR  ! $this->user->plan()->downloads()) 
		{
			// if using free plan redirect to account upgrade page with app_id
			$this->redirect('home/plans?app_id='.$app->id().'&new_app='.TRUE, 302);
		}
		else
		{
			// if using premium plan redirect to downloads page with app_id
			$message = urlencode($app->name().' has been successfully added to your account. The programming has already been completed and you can begin your downloads right away. Start with your Facebook Connect button.');
			$this->redirect('downloads/connectButton?app_id='.$app->id().'&new_app='.TRUE.'&type=connect_facebook&message='.$message.'&message_type=info', 302);
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
				$message = urlencode('The programming for '.$app->name().' has already been completed and you can begin your downloads right away. Start with your Facebook Connect button.');
	$this->redirect('downloads/connectButton?app_id='.$app->id().'&new_app='.TRUE.'&type=connect_facebook&message='.$message.'&message_type=info', 302);
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
	
	public function action_analytics()
	{
		$app_id = (int) get('app_id', 0);
		
		if ( ! $this->user->has_app_id($app_id)) 
		{
			throw new Exception('Access Denied. You do not have access to see these analytics at this time.', 1);
		}
		
		$app_dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($app_dao);
		
		$view = new View('main/home/analytics');
		$view->app           = $app;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'analytics';
		$this->template->set('content', $view);
		$this->add_css('jqplot/jquery.jqplot.min');
		$this->add_js('jqplot/jquery.jqplot.min');
		$this->add_js('jqplot/jqplot.canvasTextRenderer.min');
		$this->add_js('jqplot/jqplot.canvasAxisLabelRenderer.min');
		$this->add_js('main/home/analytics');
	}
	
	public function action_getAppAnalytics()
	{
		$app_id        = (int) get('app_id', 0);
		$type          = (string) get('type', 'logins');
		$min_timestamp = (int) get('min_timestamp', 1362117600);
		$max_timestamp = (int) get('max_timestamp', time());
		$days_ago      = (int) get('days_ago', 0); // pass this instead of min timestamp to get logins/signups from this many days ago until right now
		$format        = (string) get('format', 'json');
		
		if ($days_ago) 
		{
			$days_ago_seconds = $days_ago*86400;
			$min_timestamp = time() - $days_ago_seconds;
		}
		
		// validate
		if ($min_timestamp < 0 OR $max_timestamp > time())
		{
			throw new Exception('Invalid dates passed. Please try again', 1);
		}
		
		// check access
		if ( ! $this->user()->has_app_id($app_id))
		{
			throw new Exception('Access Denied. You cannot view this apps analytics at this time', 1);
		}
		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		
		$this->auto_render = FALSE;
		
		switch ($type) {
			case 'logins':
				if ($format === 'json') 
				{
					echo json_encode( array_values($app->count_logins($min_timestamp, $max_timestamp, array('iterate' => TRUE))) );
				}
				break;
			case 'login_counter':
				echo $app->count_logins($min_timestamp, $max_timestamp);
				break;
			case 'signups':
				if ($format === 'json')
				{
					echo json_encode( array_values($app->count_signups($min_timestamp, $max_timestamp, array('iterate' => TRUE))) );
				}
				break;
			case 'signup_counter':
				echo $app->count_signups($min_timestamp, $max_timestamp);
				break;
			default:
				trigger_error('GetAppAnalytics does not recognize type '.$type, E_USER_WARNING);
				break;
		}
	}
	
}
