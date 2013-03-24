<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Downloads Controller
 *
 * @author BRIAN ANDERSON
 */
class Controller_Downloads extends Controller_Home {
	
	public function action_index()
	{
		$app_id  = (int)  get('app_id', 0);
		$new_app = (bool) get('new_app', FALSE);
		
		// if no app_id was passed, but user only has one app, redirect
		if ( ! $app_id AND count($this->user->apps()) === 1) 
		{
			$users_apps = $this->user->apps();
			$this->redirect('downloads?app_id='.$users_apps['0']->id(), 302);
		}
		
		if ($app_id) 
		{
			$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao_app);
		}
		else
		{
			$app = FALSE;
		}
		
		$view                = new View('main/downloads/index');
		$view->app           = $app;
		$view->new_app       = $new_app;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'downloads';
		$this->template->set('content', $view);
		$this->add_js('main/downloads/index');
		$this->add_css('main/downloads/index');
		$this->add_css('back');
	}
	
	public function action_connectButton()
	{
		$app_id  = (int)   get('app_id', 0);
		$new_app = (bool) get('new_app', FALSE);
		$type    = (string) get('type', 'connect_facebook');
		
		// check access
		if ( ! $this->user->plan()->downloads()) 
		{
			throw new Exception('You must upgrade your account before attempting to download this file. To get started, <a href="/home/plan">click here</a>', 1);
		}
		
		// get app
		if ($app_id) 
		{
			$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao_app);
		}
		else
		{
			$app = FALSE;
		}
		
		$view                = new View('main/downloads/connectButton');
		$view->app           = $app;
		$view->new_app       = $new_app;
		$view->type          = $type;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'downloads';
		$this->template->set('content', $view);
		$this->add_js('main/downloads/index');
		$this->add_css('main/downloads/index');
	}
	
	public function action_sender()
	{
		$app_id  = (int)    get('app_id', 0);
		$new_app = (bool)   get('new_app', FALSE);
		$type    = (string) get('type', 'facebook');
		
		// check access
		if ( ! $this->user->plan()->downloads()) 
		{
			throw new Exception('You must upgrade your account before attempting to download this file. To get started, <a href="/home/plan">click here</a>', 1);
		}
		
		// get app
		if ($app_id) 
		{
			$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao_app);
		}
		else
		{
			$app = FALSE;
		}
		
		$view                = new View('main/downloads/sender');
		$view->app           = $app;
		$view->new_app       = $new_app;
		$view->type          = $type;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'downloads';
		$this->template->set('content', $view);
		$this->add_js('main/downloads/index');
		$this->add_css('main/downloads/index');
	}
	
	public function action_receiver()
	{
		$app_id  = (int)     get('app_id', 0);
		$new_app = (bool)    get('new_app', FALSE);
		$type    = (string ) get('type', 'facebook');
		
		// check access
		if ( ! $this->user->plan()->downloads()) 
		{
			throw new Exception('You must upgrade your account before attempting to download this file. To get started, <a href="/home/plan">click here</a>', 1);
		}
		
		// get app
		if ($app_id) 
		{
			$dao_app = Factory_Dao::create('kohana', 'app', $app_id);
			$app = Factory_Model::create($dao_app);
		}
		else
		{
			$app = FALSE;
		}
		
		$view                = new View('main/downloads/receiver');
		$view->app           = $app;
		$view->new_app       = $new_app;
		$view->type          = $type;
		$view->user          = $this->user();
		$view->header        = new View('main/home/header');
		$view->header->user  = $this->user();
		$view->sidebar       = new View('main/home/sidebar');
		$view->sidebar->page = 'downloads';
		$this->template->set('content', $view);
		$this->add_js('main/downloads/index');
		$this->add_css('main/downloads/index');
	}
	
	public function action_process()
	{
		$type   = (string) post('type', '');
		$app_id = (int)    post('app_id', 0);
		$text   = (string) post('text', '');
		$size = (string)   post('size', 'large');
		
		$data = array(
			'type' => $type,
			'text' => $text,
			'size' => $size,
		);
		
		// objects
		$hash_algo = Factory_Hash::create( Auth::instance() );
		$app_dao   = Factory_Dao::create('kohana', 'app', $app_id);
		$app       = Factory_Model::create($app_dao);
		$script    = Factory_Script::create($type, $this->user, $app, $data);
		
		// create filename
		$script->set_compression_type('zip');
		$results = $script->create( $type );
		if ( ! $results) 
		{
			throw new Exception('We cannot complete your request at this time, please try again soon', 1);
		}
		
		// redirect or print url on ajax
		if ( ! $this->request->is_ajax())
		{
			if ($type === 'connect_facebook_button' OR $type === 'login_facebook_button')
			{
				echo $script->text().' <hr> <a href="/downloads?app_id='.$app->id().'">Click Here to Return</a>';
				die;
			}
			else
			{
				$this->redirect($script->url(), 302);	
			}
		}
		else
		{
			$this->auto_render = FALSE;
			$this->response->body($script->text());
		}
	}

}
