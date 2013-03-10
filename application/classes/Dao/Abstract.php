<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract DAO class. All DAOs must extend this class.
 *
 * @author BRIAN ANDERSON
 */
abstract class Dao_Abstract {
	
	abstract public function find();
	abstract public function find_all();
	
	abstract public function update();
	
	abstract public function create();
	
	abstract public function save();
	
	abstract public function delete();
	
	abstract public function loaded();
	
	abstract public function where($column, $op, $value);
	abstract public function and_where($column, $op, $value);
	abstract public function and_where_open();
	abstract public function and_where_close();
	abstract public function or_where($column, $op, $value);
	abstract public function or_where_open();
	abstract public function or_where_close();
	
	abstract public function clear();
	
	abstract public function as_array();
	
	abstract public function count_all();
	
	abstract public function group_by($columns);
	
	abstract public function join($table, $type);
	abstract public function on($c1, $op, $c2);
	
	abstract public function order_by($column, $direction);
	
	abstract public function limit($number);
	abstract public function offset($number);
	
	abstract public function table_name();
	
}
