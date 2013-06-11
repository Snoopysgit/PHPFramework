<?php
namespace phpframework\controlers;

/**
 * Database connection controler
 * 
 * Provides basic functionalities to connect to an mySQL database and execute queries.
 * @author Christian Thommen
 */
class DatabaseControler extends Controler{
	/**
	 * Holds database hostname
	 */
	private $dbHost = 'localhost';
	/**
	 * Holds database username
	 */
	private $dbUser = 'marvadmin';
	/**
	 * Holds database password
	 */
	private $dbPwd = '1234';
	/**
	 * Holds database name
	 */
	private $database = 'mydb';
	/**
	 * Holds database connection
	 */
	private $connx = NULL;
	/**
	 * Holds possible error message
	 */
	private $error = '';

	/**
	* Creates a new instance
	*
	* connects to the database and sets the charset to UTF8
	*/
	protected function __construct(){ 
		parent::__construct();
		$this->connect();
		mysql_set_charset("UTF8",$this->connx);
	}
	/**
	* Connect to the specified database
	* 
	* @return boolean true, if connection has been established successfully
	* @throws Exception if connection to database can not be established
	*/
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
	/**
	* Get the connection object
	* 
	* @return mySQLConnection connection object returned from mysql_connect()
	*/
	public function getConnection(){
		return($this->connx); 
	}
	/**
	* Sanitizes an input string
	* 
	* removes whitespace and escapes the input string
	* @param string|integer $input stuff to sanitize
	* @return string|integer real escaped string, that can be used in SQL statements
	*/
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
	/**
	* Executes a simple select statement
	* 
	* @param string $sql an sql select statement
	* @return QueryResult|integer a QueryResult object if there where results or 0 if the query returned 0 rows
	* @throw Exception if no db connection or if the query provided failed
	*/
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
	/**
	* Executes a modify statement
	* 
	* Modify statements are: update, insert, delete, exec, ...
	* @param string $sql an sql modify statement
	* @return integer the number of rows affected by the query
	* @throw Exception if no db connection or if the query provided failed
	*/
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
	/**
	* Get the last inserted Id
	* 
	* @return integer the id of the last inserted Id (mysql_insert_id())
	*/
	public function getInsertedId(){
		$id = mysql_insert_id();
		return $id;
	}
}

/**
 * QueryResult object
 * 
 * Provides functionalities for an SQLResult object
 * @author Christian Thommen
 */
class QueryResult{
	/**
	 * Holds the SQL result
	 */
	private $result = NULL;
	/**
	 * Holds connection object
	 */
	private $connx = NULL; 
	/**
	 * Holds the number of rows
	 */
	private $numRows = 0; 

	/**
	 * Creates a new instance
	 * 
	 * @param MySQLResult $result a resultobject returned form mysql_query()
	 * @param MySqlConnection $connx a connection object from mysql_connect()
	 */
	public function __construct($result, $connx){
		$this->result = $result;
		$this->connx = $connx;
		$this->numRows = mysql_num_rows($result);
	}
	/**
	 * Get a specific row number
	 * 
	 * @param integer $row a row number to get
	 * @return boolean|array() false, if the provided $row parameter is not numeric or an array for this specific row
	 */
	public function getRow($row = NULL){
		if($row !== NULL and is_numeric($row)){
			if(mysql_data_seek($this->result, abs((int)$row))){
				return(mysql_fetch_array($this->result)); 
			}
		}else{
			return(false);
		}
	}
	/**
	 * Get an array of all rows
	 * 
	 * @return array() all rows with mysql_fetch_array packed in an array()
	 */
	public function getArray(){
		mysql_data_seek($this->result, 0); 
		$data = array(); 
		while($row = mysql_fetch_array($this->result)){
			$data[] = $row;
		}
		return($data);
	}
	/**
	 * Get an array of objects
	 * 
	 * @param string $className provide a className. It will create one instance for each row
	 * @param string $searchField provide a searchField. The searchField must be a column name or column number
	 * The objects will be packed in an assotiative array with the key 'searchField'. 
	 * Therefore the serachField should be a unique key, e.g. the ID column of a database table.
	 * @return array(object) all rows with mysql_fetch_object packed in an array()
	 */
	public function getObjects($className, $searchField){
		mysql_data_seek($this->result, 0);
		$data = array();
		while($rowObj = mysql_fetch_object($this->result, $className)){
			$data[$rowObj->$searchField] = $rowObj;
		}
		return($data);
	}
	/**
	 * Free the sql result
	 */
	public function free(){
		return(mysql_free_result($this->result));
	}
	/**
	 * Get the mysql_result
	 *
	 * to perform things manually, not needed if you use getObjects or getArray()
	 * @return MySQLResult the original result from the mySQL query
	 */
	public function getResult(){
		return($this->result);
	}
	/**
	 * Get the number of selected rows
	 * 
	 * @return integer number of selected rows in the resultset
	 */
	public function getNumRows(){
	  return($this->numRows);
	}
}   
?>