<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Dao_Mongo
 *
 * @author BRIAN ANDERSON
 */
class Dao_Mongo {
	
	/**
	 * Instance of mongo connection
	 *
	 * @var MongoClient object
	 */
	private $connection;
	
	/**
	 * Database
	 *
	 * @var MongoDB object
	 */
 	private $db;
	
	/**
	 * Create connection
	 *
	 * @param string $db 
	 * @param string $server 
	 * @param string $options 
	 * @author BRIAN ANDERSON
	 */
	public function __construct($db_name = NULL, $server = NULL, $options = array("connect" => TRUE))
	{
		$this->connection = new MongoClient($server, $options);
		if (isset($db_name))
		{
			$this->setDb($db_name);
		}
	}
	
	/**
	 * Get a collection found within the set database
	 *
	 * @param string $name 
	 * @return MongoCollection object
	 * @author BRIAN ANDERSON
	 */
	public function __get($name)
	{
  		return $this->db->selectCollection($name);
	}
	
	/**
	 * set a database by passing the database's name
	 *
	 * @param string $db. Name of DB.
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function setDb($name)
	{
		if ( ! is_string($name) )
		{
			trigger_error(__METHOD__.' expects argument 1, db, to be type string representing the name of a database.', E_USER_WARNING);
		}
		$this->db = $this->connection->$name;
	}
	
	/**
	 * Returns an array of database names found within this connection
	 *
	 * @return array
	 * @author BRIAN ANDERSON
	 */
	public function showDbs()
	{
		$results = array();
		$db_array = $this->showDbsVerbose();
		foreach($db_array['databases']  as $db)
		{
			$results[] = $db['name'];
		}
		return $results;
	}
	
	/**
	 * Returns an array of databases found within this connection. Verbose version of showDbs().
	 *
	 * @return array
	 * @author BRIAN ANDERSON
	 */
	public function showDbsVerbose()
	{
		return $this->connection->listDBs();
	}
	
	/**
	 * Shows an array of collection names found within set database.
	 *
	 * @return array
	 * @author BRIAN ANDERSON
	 */
	public function showCollections()
	{
 		return $this->db->getCollectionNames();
	}
	
	/**
	 * Removes database
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function dropDatabase()
	{
 		return $this->db->drop();
	}
	
	
}
