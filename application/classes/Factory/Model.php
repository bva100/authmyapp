<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Factory for all Model classes
 *
 * @author BRIAN ANDERSON
 */
class Factory_Model extends Factory_Abstract {
	
	/**
	 * Creates a Model object by injecting a dao
	 *
	 * @param Dao_Abstract $dao
	 * @return Model object
	 * @author BRIAN ANDERSON
	 */
	static public function create(Dao_Abstract $dao = NULL)
	{
		$table = str_replace('_', ' ', $dao->table_name());
		$table = Inflector::singular(ucwords($table));
		$table = str_replace(' ', '_', $table);
		$model_name = 'Model_'.$table;
		return( new $model_name( $dao ) );
	}
	
}
