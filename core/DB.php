<?php
namespace Core;
use \PDO;
use \PDOException;

class DB
{

	private static $_instance = null;
	private $_PDO, $_query, $_error = false, $_result, $_count = 0, $_lastInsertID = null;

	private function __construct()
	{
		try{
			$this->_PDO = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
			$this->_PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
		catch(PDOException $e){
			die($e->getMessage().'<br>'.$e->getTraceAsString());
		}
	}


	public static function getInstance()
	{
		if(!isset(self::$_instance)){
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	public function query($sql, $params = [], $class = false){
		$this->_error = false;
		if($this->_query = $this->_PDO->prepare($sql)){
			$x = 1;
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
		}

		if($this->_query->execute()){
			if($class){
				$this->_result = $this->_query->fetchAll(PDO::FETCH_CLASS, $class);
			}
			else{
				$this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
			}

			$this->_count = $this->_query->rowCount();
			$this->_lastInsertID = $this->_PDO->lastInsertId();
		}
		else{
			$this->_error = true;
		}
		return $this;
	}


	protected function _read($table, $params = [], $class)
	{
		$conditionString = '';
		$columnString = '*';
		$bind = [];
		$order = '';
		$limit = '';

		// set up conditions
		if(isset($params['conditions'])){
			if(is_array($params['conditions'])){
				foreach ($params['conditions'] as $condition) {
					$conditionString .= ' ' . $condition . ' AND';
				}
				$conditionString = trim($conditionString);
				$conditionString = rtrim($conditionString, ' AND');
			}
			else{
				$conditionString = $params['conditions'];
			}
			if($conditionString != ''){
				$conditionString = ' WHERE ' . $conditionString;
			}
		}
		// bindings
		if(array_key_exists('bind', $params)){
			$bind = $params['bind'];
		}
		// order
		if(array_key_exists('order', $params)){
			$order = ' ORDER BY ' . $params['order'];
		}
		// limit
		if(array_key_exists('limit', $params)){
			$limit = ' LIMIT ' . $params['limit'];
		}
		//columns
		if(array_key_exists('columns', $params)){
			$columnString = implode(', ', $params['columns']);
		}

		$sql = "SELECT {$columnString} FROM {$table}{$conditionString}{$order}{$limit}";

		if($this->query($sql, $bind, $class)){
			if(!count($this->_result)){return false;}
			else{return true;}
		}
		return false;
	}


	public function find($table, $params = [], $class = false)
	{
		if($this->_read($table, $params, $class)){
			return $this->getResult();
		}
		return false;
	}


	public function findFirst($table, $params = [], $class = false)
	{
		if($this->_read($table, $params, $class)){
			return $this->first();
		}
		return false;
	}



	public function insert($table, $fields = [])
	{
		$fieldString = '';
		$valueString = '';
		$values = [];

		foreach($fields as $field => $value){
			$fieldString .= '`'.$field.'`,';
			$valueString .= '?,';
			$values[] = $value;
		}
		$fieldString = rtrim($fieldString, ',');
		$valueString = rtrim($valueString, ',');
		$sql = "INSERT INTO `{$table}` ({$fieldString}) VALUES ($valueString)";
		if(!$this->query($sql, $values)->error()){
			return true;
		}
		return false;
	}



	public function update($table, $id, $fields)
	{
		$fieldString = '';
		$values = [];
		foreach($fields as $field => $value){
			$fieldString .= ' `'. $field . '` = ?,';
			$values[] = $value;
		}
		$fieldString = trim($fieldString);
		$fieldString = rtrim($fieldString, ',');
		$sql = "UPDATE `{$table}` SET {$fieldString} WHERE `id` = {$id}";

		if(!$this->query($sql, $values)->error()){
			return true;
		}
		return false;
	}


	public function delete($table, $id)
	{
		$sql = "DELETE FROM `{$table}` WHERE `id` = {$id}";
		if(!$this->query($sql)->error()){
			return true;
		}
		return false;
	}


	public function first()
	{
		return (!empty($this->_result)) ? $this->_result[0] : [];
	}


	public function count()
	{
		return $this->_count;
	}


	public function lastId()
	{
		return $this->_lastInsertID;
	}


	public function getResult()
	{
		return $this->_result;
	}


	public function get_columns($table)
	{
		return $this->query("SHOW COLUMNS FROM {$table}")->getResult();
	}


	public function error()
	{
		return $this->_error;
	}



}
