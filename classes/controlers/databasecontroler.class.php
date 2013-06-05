<?php
namespace phpframework\controlers;

class DatabaseControler extends Controler{
	private $dbHost = 'localhost'; 
	private $dbUser = 'marvadmin';
	private $dbPwd = '1234'; 
	private $database = 'mydb';
	private $connx = NULL; 
	private $error = ''; 

	protected function __construct(){ 
		parent::__construct();
		$this->connect();
		mysql_set_charset("UTF8",$this->connx);
	}
	private function connect(){
		$connx = @mysql_connect($this->dbHost, $this->dbUser, $this->dbPwd); 
		if($connx != FALSE){ 
			$this->connx = $connx; 
			$db = mysql_select_db($this->database, $this->connx); 
			if($db == FALSE){ 
				$this->error = "Unable to select DB: " . mysql_error(); 
				throw new Exception($this->error);
			}
			return(TRUE);
		} 
		$this->error = "Unable to connect to DBMS: " . mysql_error(); 
		throw new Exception($this->error);
	}
	public function getConnection(){
		return($this->connx); 
	}
	public static function sanitize($input){
		$input = trim($input);
		if(!is_numeric($input)){
			if(get_magic_quotes_gpc()){
				$input = stripslashes($input);
			}
			$input = mysql_real_escape_string($input);
		}
		return($input);
	}
	public function select($sql){
		if(!$this->connx){ 
			$this->error = "Cannot process query, no DB connection.";
			throw new Exception($this->error);
		}
		$result = mysql_query($sql, $this->connx);
		if($result){
			if(mysql_num_rows($result)){ 
				return(new QueryResult($result, $this->connx)); 
			}else{
				return(0); 
			}
		}else{
			$this->error = "Query failed ($sql): " . mysql_error();
			throw new Exception($this->error);
		}
	}
	public function modify($sql){
		if(!$this->connx){
			$this->error = "Cannot process query, no DB connection.";
			throw new Exception($this->error);
		}
		$result = mysql_query($sql, $this->connx);
		if($result){
			return(mysql_affected_rows($this->connx));
		}else{
			$this->error = "Query failed ($sql): " . mysql_error();
			throw new Exception($this->error);
		}
	}
	public function getInsertedId(){
		$id = mysql_insert_id();
		return $id;
	}
}

class QueryResult{
	private $result = NULL; 
	private $connx = NULL; 
	private $numRows = 0; 

	public function __construct($result, $connx){
		$this->result = $result;
		$this->connx = $connx;
		$this->numRows = mysql_num_rows($result);
	}
	public function getRow($row = NULL){
		if($row !== NULL and is_numeric($row)){
			if(mysql_data_seek($this->result, abs((int)$row))){
				return(mysql_fetch_array($this->result)); 
			}
		}else{
			return(false);
		}
	}
	public function getArray(){
		mysql_data_seek($this->result, 0); 
		$data = array(); 
		while($row = mysql_fetch_array($this->result)){
			$data[] = $row;
		}
		return($data);
	}
	public function getObjects($className, $searchField){
		mysql_data_seek($this->result, 0);
		$data = array();
		while($rowObj = mysql_fetch_object($this->result, $className)){
			$data[$rowObj->$searchField] = $rowObj;
		}
		return($data);
	}
	public function free(){
		return(mysql_free_result($this->result));
	}
	public function getResultId(){
		return($this->result);
	}
	public function getNumRows(){
	  return($this->numRows);
	}
}   
?>