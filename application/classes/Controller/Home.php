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
		$message     = (string) get('message', '');
		$message_type = (string) get('message_type', 'success');
		
		$view                      = new View('main/home/index');
		$view->user                = $this->user();
		if ($message AND $message_type) 
		{
			$view->alert               = new View('alert');
			$view->alert->message      = $message;
			$view->alert->type         = $message_type;
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
			$senderUri = 'amadirectionsender/index.php';
		}
		if ( ! $receiverUri ) 
		{
			$receiverUri = 'amareceiver/index.php';
		}
		
		// create app
		$dao_app = Factory_Dao::create('kohana', 'app');
		$app     = Model_App::create_with_name_and_organization_id($dao_app, $name, $org->id());
		$app->set_secret(TRUE);
		$app->set_access_token(TRUE);
		$app->set_primary_user_id($this->user->id(), TRUE);
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
		
		// does this app belong to this user?
		if ( $app_id AND ! $this->user->has_app_id($app_id)) 
		{
			throw new Exception('You cannot change the settings for this app at this time', 1);
		}
		
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
		$plan_id       = (int) post('plan_id', 1);
		$app_id        = (int) post('app_id', 0);
		$new_app       = (bool) post('new_app', FALSE);
		
		// create free dao
		$free_dao_plan = Factory_Dao::create('kohana', 'plan')->where('name', '=', 'free')->find();
		
		// if anything but a free plan was created, go through wepay checkout flow
		if ( (int) $free_dao_plan->id !== $plan_id )
		{
			$this->redirect( $uri = URL::base(TRUE).'pay/plan?app_id='.$app_id.'&plan_id='.$plan_id.'&new_app='.$new_app, 302);
		}
		
		// does user have a plan? If YES, cancel it
		if ($this->user()->plan_wepay_preapproval_id()) 
		{
			$wepay = Factory_Payment::create('wepay');
			$cancel_response = $wepay->request('/preapproval/cancel', array('preapproval_id' => $this->user->plan_wepay_preapproval_id()));
			$this->user->set_plan_wepay_preapproval_id(0);
		}
		
		// set plan id
		$this->user->set_plan_id($plan_id);
		
		// redirect
		if ($app_id AND $new_app )
		{
			$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao_app);
			$message = urlencode( $app->name().' is ready to go. Be sure to click on the help link in the navigation bar for integration tutorials.');
			$this->redirect('home?message='.$message.'&alert_type=success', 302);
		}
		else
		{
			$this->redirect('home/plans', 302);
		}
	}
	
	public function action_analytics()
	{
		$app_id = (int) get('app_id', 0);
		
		if ( ! $app_id) 
		{
			if (count($this->user->apps()) === 1)
			{
				$app_arr = $this->user->apps();
				$app_id = $app_arr['0']->id();
			}
			else
			{
				$this->redirect('home/analyticSelector', 302);
			}
		}
		
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
	
	public function action_analyticSelector()
	{
		$view                = new View('main/home/analyticSelector');
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'analytics';
		$this->template->set('content', $view);
	}
	
	public function action_organizations()
	{
		$message = (string) get('message', '');
		$message_type = (string) get('message_type', 'success');
		
		$view                = new View('main/home/organizations');
		$view->user          = $this->user();
		if ($message AND $message_type) 
		{
			$view->alert = new View('alert');
			$view->alert->message = $message;
			$view->alert->type = $message_type;
		}
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'organizations';
		$this->template->set('content', $view);
	}
	
	public function action_addNewOrganizationProcess()
	{
		$name = (string) post('name', '');
		
		if ( ! $name) 
		{
			throw new Exception('Please add a name and try again', 1);
		}
		
		$dao = Factory_Dao::create('kohana', 'organization');
		$org = Model_Organization::create_with_name($dao, $name);
		$org->set_state(Model_Organization::STATE_ACTIVE);
		$this->user->add_organization($org->id());
		
		$message = urlencode($org->name().' has been added to your account. If you\'d like to add an app or website to '.$org->name().', you can do so in that apps settings page');
		$this->redirect('/home/organizations?message='.$message.'&message_type=success', 302);
	}
	
}
