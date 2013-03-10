<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract Model. All model classes should extend this class except DAO type models
 *
 * @author BRIAN ANDERSON
 */
abstract class Model_Abstract {
	
	/**
	 * DAO. Database access object.
	 *
	 * @var Dao_Abstract object
	 */
	private $dao;
	
	/**
	 * Constructor inject's a dao
	 *
	 * @param Dao_Abstract $dao 
	 * @author BRIAN ANDERSON
	 */
	public function __construct(Dao_Abstract $dao)
	{
		$this->set_dao( $dao );
	}
	
	/**
	 * set dao
	 *
	 * @param object $dao
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_dao(Dao_Abstract $dao)
	{
		$this->dao = $dao;
	}
	
	/**
	 * get dao
	 *
	 * @return Dao_Abstract object
	 * @author BRIAN ANDERSON
	 */
	public function dao()
	{
		return($this->dao);
	}
	
	/**
	 * get id
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function id()
	{
		return( (int) $this->dao->id);
	}
	
	/**
	 * Run update query
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function db_update()
	{
		$this->dao->update();
	}
	
	/**
	 * Run delete query
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function delete()
	{
		$this->dao->delete();
	}
	
	/**
	 * set state
	 *
	 * @param int $state
	 * @param bool $lazy
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_state($state, $lazy = FALSE)
	{
		if ( ! is_int($state) )
		{
			trigger_error('set_state expects argument 1 to be type int', E_USER_WARNING);
		}
		$this->dao->state = $state;
		if ( ! $lazy)
		{
			$this->db_update();
		}
	}
	
	/**
	 * get state
	 *
	 * @return int
	 * @author BRIAN ANDERSON
	 */
	public function state()
	{
		return( (int) $this->dao->state);
	}
	
	/**
	 * get create_timestamp)
	 *
	 * @return int. Unix timestamp.
	 * @author BRIAN ANDERSON
	 */
	public function create_timestamp()
	{
		return( (int) $this->dao->create_timestamp);
	}
	
	/**
	 * get state_timestamp
	 *
	 * @return int. Unix timestamp.
	 * @author BRIAN ANDERSON
	 */
	public function state_timestamp()
	{
		return($this->dao->state_timestamp);
	}
	
	/**
	 * get update_timestamp
	 *
	 * @return int. Unix timestamp.
	 * @author BRIAN ANDERSON
	 */
	public function update_timestamp()
	{
		return( (int) strtotime($this->dao->update_timestamp) );
	}
}
