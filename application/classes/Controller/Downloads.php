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
	
	public function action_process()
	{
		$type   = (string) post('type', '');
		$app_id = (int)    post('app_id', 0);
		$text   = (string) post('text', '');
		$size = (string) post('size', 'large');
		
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
			$this->response->body($script->text());
		}
	}

}
