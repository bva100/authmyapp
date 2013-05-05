<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Mongo test class. Delete this later.
 *
 * @author BRIAN ANDERSON
 */
class Controller_Mongo extends Controller {
	
	public function action_dbs()
	{
		$db = new Dao_Mongo();
		echo Debug::vars($db->showDbs()); die;
	}
	
	public function action_find()
	{
		$db = new Dao_Mongo('authmyapp');
		$cursor = $db->test->find()->skip(1)->limit(2);
		foreach ($cursor as $doc) 
		{
			echo Debug::vars($doc);
		}
	}
	
	public function action_update()
	{
		$db = new Dao_Mongo('authmyapp');
		// $results = $db->test->update( array('_id' => Dao_Mongo::id('518149009a5a6e3a80d0e722')), array('$set' => array('gender' => 'm')) );
		$results = $db->test->update( MongoHelper::findId('518149009a5a6e3a80d0e722'), MongoHelper::set( array('handle' => 'bva100') ) );
		echo Debug::vars($results); die;
	}
	
	public function action_collections()
	{
		$m = new MongoClient();
		$db = $m->selectDB("authmyapp");

		$list = $db->listCollections();
		echo Debug::vars($list); die;
		foreach ($list as $collection) {
			echo $collection->getName();
		}
	}
	
	public function action_index()
	{
		
		$connect = new MongoClient();
		$db = $connect->authmyapp;
		$collection = $db->foobar;
		
		// $doc = array (
		// 	'name' => 'brian',
		// 	'email' => 'brianvanderson@gmail.com',
		// );
		// $collection->insert( $doc );
		$it = $collection->find();
		$results = iterator_to_array($it);
		echo Debug::vars($results); die;

		// $cursor = $collection->find( array('id' => new MongoId("51808d466803fa9a6b000000") )  );
		// $cursor = iterator_to_array($cursor);
		// foreach ($cursor as $doc) 
		// {
		// 	echo Debug::vars($doc), '<br>';
		// }
	// 	
	// 	$doc_id = "51808d466803fa9a6b000000";
	// 
	// 	    $cursor = $collection->find( );
	// 		$cursor = iterator_to_array($cursor);
	// 	    // $cursor2array = iterator_to_array($cursor);
	// 	    // echo "<pre>"; print_r($cursor2array); echo "</pre>";
	// 	    // 
	// 	    // foreach ( $cursor2array[$doc_id] as $key => $value )
	// 	    // {
	// 	    //      echo "$key => $value <br/>";
	// 	    // }
	// 	echo Debug::vars($cursor); die;
	}
	
}
