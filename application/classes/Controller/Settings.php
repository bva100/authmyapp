<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Settings controller. Extends home.
 *
 * @author BRIAN ANDERSON
 */
class Controller_Settings extends Controller_Home {
	
	public function action_app()
	{
		$app_id = (int) get('app_id', 0);
		
		if ( ! $this->user->has_app_id($app_id)) 
		{
			throw new Exception('Access denied. You cannot change the settings for this app at this time', 1);
		}
		$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
		$app     = Factory_Model::create($dao_app);
		$dao_org = Factory_Dao::create('kohana', 'organization', $app->organization_id());
		$org     = Factory_Model::create($dao_org);
		
		$view = new View('main/settings/index');
		$view->app           = $app;
		$view->org           = $org;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'setingsApp';
		$this->template->set('content', $view);
		$this->add_css('main/settings/index');
		$this->add_js('main/settings/index');
	}
	
	public function action_appProcessState()
	{
		$app_id   = (int) post('app_id', 0);
		$state    = (int) post('state', 0);
		$redirect = (string) post('redirect', Request::initial()->referrer());
		
		if ( ! $this->user->has_app_id($app_id)) 
		{
			throw new Exception('Access denied. You cannot change the settings for this app at this time', 1);
		}
		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		$app->set_state($state);
		$this->redirect($redirect, 302);
	}
	
	public function action_appFacebookDialog()
	{
		$app_id = (int) get('app_id', 0);
		
		if ( ! $this->user->has_app_id($app_id)) 
		{
			throw new Exception('Access denied. You cannot change the settings for this app at this time', 1);
		}
		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		
		$view = new View('main/settings/facebookDialog');
		$view->app           = $app;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = NULL;
		$this->template->set('content', $view);
		$this->add_css('main/settings/index');
		$this->add_js('main/settings/index');
	}
	
	public function action_appFacebookDialogProcess()
	{
		$app_id          = (int) post('app_id', 0);
		$facebook_app_id = post('facebook_app_id', '');
		$facebook_secret = post('facebook_secret', '');
		$redirect        = (string) post('redirect', 'settings/appFacebookDialog?app_id='.$app_id);
		
		if ( ! $this->user->has_app_id($app_id)) 
		{
			throw new Exception('Access denied. You cannot change the settings for this app at this time', 1);
		}
		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		$app->set_facebook_app_id($facebook_app_id, TRUE);
		$app->set_facebook_secret($facebook_secret);
		$this->redirect($redirect, 302);
	}
	
	public function action_updateAppSecret()
	{
		$app_id = (int) post('app_id', 0);
		$this->auto_render = FALSE;
		if ( ! $this->user->has_app_id($app_id)) 
		{
			throw new Exception('Access denied. You cannot change the settings for this app at this time', 1);
		}
		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		$app->set_secret();
		echo $app->secret();
	}
	
	public function action_updateAppOrg()
	{
		$app_id = (int) post('app_id', 0);
		$org_id = (int) post('org_id', 0);
		$redirect = (string) post('redirect', '/settings/app?app_id='.$app_id);
		
		$this->auto_render = FALSE;
		if ( ! $this->user->has_app_id($app_id)) 
		{
			throw new Exception('Access denied. You cannot change the settings for this app at this time', 1);
		}
		$dao = Factory_Dao::create('kohana', 'app', $app_id);
		$app = Factory_Model::create($dao);
		$app->set_organization_id($org_id);
		$this->redirect($redirect, 302);
	}
	
	public function action_account()
	{
		echo 'account settings here'; die();
	}
	
}
